<?php

namespace Tests;

use Symfony\Component\HttpFoundation\Response;

class AchievementTest extends TestCase
{
    const ACHIEVEMENT_URL = '/api/achievements';

    public function testCreateAsAdmin()
    {
        $response = $this->actingAs($this->admin)->json('post', self::ACHIEVEMENT_URL, [
            'script_id' => 1,
            'title' => 'title5',
            'incomplete_cover_id' => 1,
            'complete_cover_id' => 2,
            'incomplete_message' => 'msg',
            'complete_message' => 'msg'
        ]);

        $response->assertOk();

        $this->assertEqualsFixture('create_achievement.json', $response->json());

        $this->assertDatabaseHas('achievements', [
            'id' => 6,
            'script_id' => 1,
            'title' => 'title5',
            'incomplete_cover_id' => 1,
            'complete_cover_id' => 2,
            'incomplete_message' => 'msg',
            'complete_message' => 'msg'
        ]);
    }

    public function testCreateAsManager()
    {
        $response = $this->actingAs($this->manager)->json('post', self::ACHIEVEMENT_URL, [
            'script_id' => 1,
            'title' => 'title5',
            'incomplete_cover_id' => 1,
            'complete_cover_id' => 2,
            'incomplete_message' => 'msg',
            'complete_message' => 'msg'
        ]);

        $response->assertOk();
    }

    public function createNoPermission()
    {
        $response = $this->actingAs($this->employee)->json('post', self::ACHIEVEMENT_URL, [
            'script_id' => 1,
            'title' => 'title5',
            'incomplete_cover_id' => 1,
            'complete_cover_id' => 2,
            'incomplete_message' => 'msg',
            'complete_message' => 'msg'
        ]);

        $response->assertForbidden();
    }

    public function testDeleteAsAdmin()
    {
        $response = $this->actingAs($this->admin)->json('delete', self::ACHIEVEMENT_URL . '/1');

        $response->assertNoContent();

        $this->assertDatabaseMissing('achievements', [
            'id' => 1
        ]);
    }

    public function testDeleteAsManager()
    {
        $response = $this->actingAs($this->manager)->json('delete', self::ACHIEVEMENT_URL . '/1');

        $response->assertNoContent();

        $this->assertDatabaseMissing('achievements', [
            'id' => 1
        ]);
    }

    public function testDeleteNoPermission()
    {
        $response = $this->actingAs($this->employee)->json('delete', self::ACHIEVEMENT_URL . '/1');

        $response->assertForbidden();
    }

    public function testDeleteNotFound()
    {
        $response = $this->actingAs($this->admin)->json('delete', self::ACHIEVEMENT_URL . '/0');

        $response->assertNotFound();
    }

    public function testDeleteInvalidId()
    {
        $response = $this->actingAs($this->admin)->json('delete', self::ACHIEVEMENT_URL . '/gg');

        $response->assertNotFound();
    }

    public function testDeleteWithoutId()
    {
        $response = $this->actingAs($this->admin)->json('delete', self::ACHIEVEMENT_URL);

        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function testUpdateAsAdmin()
    {
        $response = $this->actingAs($this->admin)->json('put', self::ACHIEVEMENT_URL . '/1', [
            'title' => 'title12',
            'incomplete_cover_id' => 1,
            'complete_cover_id' => 2,
            'incomplete_message' => 'msg',
            'complete_message' => 'msg'
        ]);

        $this->assertDatabaseHas('achievements', [
            'id' => 1,
            'title' => 'title12',
            'incomplete_cover_id' => 1,
            'complete_cover_id' => 2,
            'incomplete_message' => 'msg',
            'complete_message' => 'msg'
        ]);

        $response->assertNoContent();
    }

    public function testUpdateAsManager()
    {
        $response = $this->actingAs($this->manager)->json('put', self::ACHIEVEMENT_URL . '/1', [
            'title' => 'title12',
            'incomplete_cover_id' => 1,
            'complete_cover_id' => 2,
            'incomplete_message' => 'msg',
            'complete_message' => 'msg'
        ]);

        $response->assertNoContent();
    }

    public function testUpdateNotFound()
    {
        $response = $this->actingAs($this->admin)->json('put', self::ACHIEVEMENT_URL . '/0', [
            'title' => 'title12',
            'incomplete_cover_id' => 1,
            'complete_cover_id' => 2,
            'incomplete_message' => 'msg',
            'complete_message' => 'msg'
        ]);

        $response->assertNotFound();
    }

    public function testUpdateInvalidId()
    {
        $response = $this->actingAs($this->admin)->json('put', self::ACHIEVEMENT_URL . '/gg', [
            'title' => 'title12',
            'incomplete_cover_id' => 1,
            'complete_cover_id' => 2,
            'incomplete_message' => 'msg',
            'complete_message' => 'msg'
        ]);

        $response->assertNotFound();
    }

    public function testUpdateWithoutId()
    {
        $response = $this->actingAs($this->admin)->json('put', self::ACHIEVEMENT_URL);

        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function testUpdateNoPermission()
    {
        $response = $this->actingAs($this->employee)->json('put', self::ACHIEVEMENT_URL . '/1', [
            'title' => 'title12',
            'incomplete_cover_id' => 1,
            'complete_cover_id' => 2,
            'incomplete_message' => 'msg',
            'complete_message' => 'msg'
        ]);

        $response->assertForbidden();
    }

    public function testGet()
    {
        $response = $this->actingAs($this->admin)->json('get', self::ACHIEVEMENT_URL . '/1');

        $response->assertOk();

        $this->assertEqualsFixture('get_achievement.json', $response->json());
    }

    public function testGetNotFound()
    {
        $response = $this->actingAs($this->admin)->json('get', self::ACHIEVEMENT_URL . '/0');

        $response->assertNotFound();
    }

    public function testGetInvalidId()
    {
        $response = $this->actingAs($this->admin)->json('get', self::ACHIEVEMENT_URL . '/gg');

        $response->assertNotFound();
    }

    public function getSearchFilters(): array
    {
        return [
            [
                'filter' => [],
                'result' => 'search_achievements.json'
            ],
            [
                'filter' => ['query' => '1'],
                'result' => 'get_achievement_by_query.json'
            ],
            [
                'filter' => [
                    'per_page' => 1,
                    'page' => 2
                ],
                'result' => 'search_achievements_pagination.json',
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
        $response = $this->actingAs($this->admin)->json('get', self::ACHIEVEMENT_URL, $filter);

        $response->assertOk();

        $this->assertEqualsFixture($fixture, $response->json());
    }
}
