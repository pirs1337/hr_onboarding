<?php

namespace Tests;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RonasIT\Support\Traits\FilesUploadTrait;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Arr;

class MediaTest extends TestCase
{
    use FilesUploadTrait;

    const MEDIA_URL = '/api/media';

    protected $file;

    public function setUp(): void
    {
        parent::setUp();

        $this->file = UploadedFile::fake()->image('file.png', 600, 600);
    }

    public function testCreateAsAdmin()
    {
        $response = $this->actingAs($this->admin)->json('post', self::MEDIA_URL, ['file' => $this->file]);

        $response->assertOk();

        $responseData = $response->json();

        $this->assertEqualsFixture('create_media.json', Arr::except($responseData, ['name', 'link', 'source']));

        $this->assertDatabaseHas('media', [
            'id' => 5,
            'name' => $responseData['name'],
            'user_id' => $this->admin->id,
        ]);
    }

    public function testCreateAsManager()
    {
        $response = $this->actingAs($this->manager)->json('post', self::MEDIA_URL, ['file' => $this->file]);

        $response->assertOk();
    }

    public function testCreateNoPermission()
    {
        $response = $this->actingAs($this->employee)->json('post', self::MEDIA_URL, ['file' => $this->file]);

        $response->assertForbidden();
    }

    public function testCreateCheckResponse()
    {
        $response = $this->actingAs($this->admin)->json('post', self::MEDIA_URL, ['file' => $this->file]);

        $responseData = $response->json();

        $this->assertDatabaseHas('media', [
            'id' => 5,
            'link' => $responseData['link']
        ]);

        Storage::assertExists($this->getFilePathFromUrl($responseData['link']));
    }

    public function testCreateNoAuth()
    {
        $response = $this->json('post', self::MEDIA_URL, ['file' => $this->file]);

        $response->assertUnauthorized();
    }

    public function testDelete()
    {
        Storage::putFileAs('/', new File($this->file), 'file.png');

        $response = $this->actingAs($this->admin)->json('delete', self::MEDIA_URL . '/1');

        $response->assertNoContent();

        $this->assertDatabaseMissing('media', [
            'id' => 1
        ]);

        Storage::assertMissing('file.png');
    }

    public function testDeleteAsNotOwner()
    {
        $response = $this->actingAs($this->admin)->json('delete', self::MEDIA_URL . '/4');

        $response->assertForbidden();
    }

    public function testDeleteInvalidId()
    {
        $response = $this->actingAs($this->admin)->json('delete', self::MEDIA_URL . '/dfsdfss');

        $response->assertNotFound();
    }

    public function testDeleteWithoutParam()
    {
        $response = $this->actingAs($this->admin)->json('delete', self::MEDIA_URL);

        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function testDeleteNotFound()
    {
        $response = $this->actingAs($this->admin)->json('delete', self::MEDIA_URL . '/0');

        $response->assertNotFound();
    }

    public function testGet()
    {
        $response = $this->actingAs($this->admin)->json('get', self::MEDIA_URL . '/1');

        $response->assertOk();

        $this->assertEqualsFixture('get_media.json', $response->json());
    }

    public function testGetNotFound()
    {
        $response = $this->actingAs($this->admin)->json('get', self::MEDIA_URL . '/0');

        $response->assertNotFound();
    }

    public function testGetWithoutParam()
    {
        $response = $this->actingAs($this->admin)->json('get', self::MEDIA_URL);

        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    public function testGetNotFoundContent()
    {
        $response = $this->actingAs($this->admin)->json('get', self::MEDIA_URL . '/0/content');

        $response->assertNotFound();
    }

    public function testGetContent()
    {
        Storage::putFileAs('/', new File($this->file), 'file.png');

        $response = $this->actingAs($this->admin)->json('get', self::MEDIA_URL . '/1/content');

        $response->assertRedirect('http://localhost/storage/file.png');
    }

    public function tearDown(): void
    {
        $this->clearUploadedFilesFolder();

        parent::tearDown();
    }
}
