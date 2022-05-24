<?php

namespace Tests;

use App\Services\UserService;
use App\Mail\PasswordSetup;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use RonasIT\Support\Traits\MockClassTrait;
use Symfony\Component\HttpFoundation\Response;

class UserTest extends TestCase
{
    use MockClassTrait;

    protected const USER_URL = '/api/users';

    private int $count;

    public function setUp(): void
    {
        parent::setUp();

        $this->count = User::all()->count();
    }

    public function testGetUsersWithoutRights()
    {
        $response = $this->actingAs($this->employee)->json('get', self::USER_URL);

        $response->assertForbidden();
    }

    public function getSearchFilters(): array
    {
        return [
            [
                'filter' => [],
                'result' => 'get_all_users.json'
            ],
            [
                'filter' => [
                    'per_page' => 2,
                    'page' => 2
                ],
                'result' => 'get_all_users_pagination.json'
            ],
            [
                'filter' => [
                    'roles_ids' => [3]
                ],
                'result' => 'get_employees.json'
            ]
        ];
    }

    /**
     * @dataProvider  getSearchFilters
     *
     * @param array $filter
     * @param string $fixture
     */
    public function testSearch(array $filter, string $fixture)
    {
        $response = $this->actingAs($this->admin)->json('get', self::USER_URL, $filter);

        $response->assertOk();

        $this->assertEqualsFixture($fixture, $response->json());
    }

    public function testCreate()
    {
        $data = $this->getJsonFixture('create_user.json');

        Mail::fake();
        $this->mockClass(UserService::class,  [
            ['method' => 'generatePassword', 'result' => ['password', 'password_hash']]
        ]);

        $response = $this->actingAs($this->admin)->json('post', self::USER_URL, $data);

        $response->assertOk();

        Mail::assertSent(PasswordSetup::class);
        $this->assertEqualsFixture('created_user.json', $response->json());
        $this->assertDatabaseHas('users', $this->getJsonFixture('created_user_database.json'));
    }

    public function testCreateWithScripts()
    {
        $data = $this->getJsonFixture('create_user_with_scripts.json');

        Mail::fake();
        $this->mockClass(UserService::class,  [
            ['method' => 'generatePassword', 'result' => ['password', 'password_hash']]
        ]);

        $response = $this->actingAs($this->admin)->json('post', '/api/users', $data);

        $response->assertOk();

        Mail::assertSent(PasswordSetup::class);
        $this->assertEqualsFixture('created_user.json', $response->json());
        $this->assertDatabaseHas('users', $this->getJsonFixture('created_user_database.json'));
        $this->assertDatabaseHas('script_user', ['user_id' => 4, 'script_id' => 1]);
        $this->assertDatabaseHas('script_user', ['user_id' => 4, 'script_id' => 3]);
    }

    public function testCreateNoPermission()
    {
        $data = $this->getJsonFixture('create_user.json');

        Mail::fake();

        $response = $this->actingAs($this->employee)->json('post', self::USER_URL, $data);

        $response->assertForbidden();

        Mail::assertNotSent(PasswordSetup::class);
        $this->assertDatabaseCount('users', $this->count);
    }

    public function testCreateNotAuth()
    {
        $data = $this->getJsonFixture('create_user.json');

        Mail::fake();

        $response = $this->json('post', self::USER_URL, $data);

        $response->assertUnauthorized();

        Mail::assertNotSent(PasswordSetup::class);
        $this->assertDatabaseCount('users', $this->count);
    }

    public function testCreateAdmin()
    {
        $data = $this->getJsonFixture('create_admin.json');

        Mail::fake();

        $response = $this->actingAs($this->admin)->json('post', self::USER_URL, $data);

        $response->assertUnprocessable();

        Mail::assertNotSent(PasswordSetup::class);
        $this->assertDatabaseCount('users', $this->count);
    }

    public function testCreateUserWithDefaultRole()
    {
        $data = $this->getJsonFixture('create_user_default_role.json');

        Mail::fake();
        $this->mockClass(UserService::class,  [
            ['method' => 'generatePassword', 'result' => ['password', 'password_hash']]
        ]);

        $response = $this->actingAs($this->admin)->json('post', self::USER_URL, $data);

        $response->assertOk();

        Mail::assertSent(PasswordSetup::class);
        $this->assertEqualsFixture('created_user_default_role.json', $response->json());
        $this->assertDatabaseHas('users', $this->getJsonFixture('created_user_default_role_database.json'));
    }

    public function testUpdateAsAdmin()
    {
        $data = $this->getJsonFixture('update_user.json');

        $response = $this->actingAs($this->admin)->json('put', self::USER_URL . '/1', $data);

        $response->assertNoContent();

        $this->assertDatabaseHas('users', $this->getJsonFixture('update_user_database.json'));
    }

    public function testUpdateAsManager()
    {
        $data = $this->getJsonFixture('update_user.json');

        $response = $this->actingAs($this->manager)->json('put', self::USER_URL . '/1', $data);

        $response->assertNoContent();
    }

    public function testUpdateNoPermission()
    {
        $data = $this->getJsonFixture('update_user.json');

        $response = $this->actingAs($this->employee)->json('put', self::USER_URL . '/1', $data);

        $response->assertForbidden();
    }

    public function testUpdateWithScripts()
    {
        $data = $this->getJsonFixture('update_user_with_scripts.json');

        $response = $this->actingAs($this->admin)->json('put', self::USER_URL . '/1', $data);

        $response->assertNoContent();

        $this->assertDatabaseHas('users', $this->getJsonFixture('update_user_database.json'));
        $this->assertDatabaseHas('script_user', ['user_id' => 1, 'script_id' => 1]);
        $this->assertDatabaseHas('script_user', ['user_id' => 1, 'script_id' => 3]);
        $this->assertDatabaseMissing('script_user', ['user_id' => 1, 'script_id' => 2]);
    }

    public function testUpdateNotFound()
    {
        $data = $this->getJsonFixture('update_user.json');

        $response = $this->actingAs($this->admin)->json('put', self::USER_URL . '/0', $data);

        $response->assertNotFound();
    }

    public function testUpdateInvalidId()
    {
        $data = $this->getJsonFixture('update_user.json');

        $response = $this->actingAs($this->admin)->json('put', self::USER_URL . '/gg', $data);

        $response->assertNotFound();
    }

    public function testUpdateNoAuth()
    {
        $data = $this->getJsonFixture('update_user.json');

        $response = $this->json('put', self::USER_URL . '/1', $data);

        $response->assertUnauthorized();
    }

    public function testUpdateWithoutId()
    {
        $data = $this->getJsonFixture('update_user.json');

        $response = $this->actingAs($this->admin)->json('put', self::USER_URL, $data);

        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }
}
