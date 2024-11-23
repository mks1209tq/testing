<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Position;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

test('index displays view', function (): void {
    $positions = Position::factory()->count(3)->create();

    $response = get(route('positions.index'));

    $response->assertOk();
    $response->assertViewIs('position.index');
    $response->assertViewHas('positions');
});


test('create displays view', function (): void {
    $response = get(route('positions.create'));

    $response->assertOk();
    $response->assertViewIs('position.create');
});


test('store uses form request validation')
    ->assertActionUsesFormRequest(
        \App\Http\Controllers\PositionController::class,
        'store',
        \App\Http\Requests\PositionStoreRequest::class
    );

test('store saves and redirects', function (): void {
    $response = post(route('positions.store'));

    $response->assertRedirect(route('positions.index'));
    $response->assertSessionHas('position.id', $position->id);

    assertDatabaseHas(positions, [ /* ... */ ]);
});


test('show displays view', function (): void {
    $position = Position::factory()->create();

    $response = get(route('positions.show', $position));

    $response->assertOk();
    $response->assertViewIs('position.show');
    $response->assertViewHas('position');
});


test('edit displays view', function (): void {
    $position = Position::factory()->create();

    $response = get(route('positions.edit', $position));

    $response->assertOk();
    $response->assertViewIs('position.edit');
    $response->assertViewHas('position');
});


test('update uses form request validation')
    ->assertActionUsesFormRequest(
        \App\Http\Controllers\PositionController::class,
        'update',
        \App\Http\Requests\PositionUpdateRequest::class
    );

test('update redirects', function (): void {
    $position = Position::factory()->create();

    $response = put(route('positions.update', $position));

    $position->refresh();

    $response->assertRedirect(route('positions.index'));
    $response->assertSessionHas('position.id', $position->id);
});


test('destroy deletes and redirects', function (): void {
    $position = Position::factory()->create();

    $response = delete(route('positions.destroy', $position));

    $response->assertRedirect(route('positions.index'));

    assertSoftDeleted($position);
});
