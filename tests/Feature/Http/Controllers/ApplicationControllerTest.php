<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Application;
use App\Models\Vacancy;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

test('index displays view', function (): void {
    $applications = Application::factory()->count(3)->create();

    $response = get(route('applications.index'));

    $response->assertOk();
    $response->assertViewIs('application.index');
    $response->assertViewHas('applications');
});


test('create displays view', function (): void {
    $response = get(route('applications.create'));

    $response->assertOk();
    $response->assertViewIs('application.create');
});


test('store uses form request validation')
    ->assertActionUsesFormRequest(
        \App\Http\Controllers\ApplicationController::class,
        'store',
        \App\Http\Requests\ApplicationStoreRequest::class
    );

test('store saves and redirects', function (): void {
    $vacancy = Vacancy::factory()->create();

    $response = post(route('applications.store'), [
        'vacancy_id' => $vacancy->id,
    ]);

    $applications = Application::query()
        ->where('vacancy_id', $vacancy->id)
        ->get();
    expect($applications)->toHaveCount(1);
    $application = $applications->first();

    $response->assertRedirect(route('applications.index'));
    $response->assertSessionHas('application.id', $application->id);
});


test('show displays view', function (): void {
    $application = Application::factory()->create();

    $response = get(route('applications.show', $application));

    $response->assertOk();
    $response->assertViewIs('application.show');
    $response->assertViewHas('application');
});


test('edit displays view', function (): void {
    $application = Application::factory()->create();

    $response = get(route('applications.edit', $application));

    $response->assertOk();
    $response->assertViewIs('application.edit');
    $response->assertViewHas('application');
});


test('update uses form request validation')
    ->assertActionUsesFormRequest(
        \App\Http\Controllers\ApplicationController::class,
        'update',
        \App\Http\Requests\ApplicationUpdateRequest::class
    );

test('update redirects', function (): void {
    $application = Application::factory()->create();
    $vacancy = Vacancy::factory()->create();

    $response = put(route('applications.update', $application), [
        'vacancy_id' => $vacancy->id,
    ]);

    $application->refresh();

    $response->assertRedirect(route('applications.index'));
    $response->assertSessionHas('application.id', $application->id);

    expect($vacancy->id)->toEqual($application->vacancy_id);
});


test('destroy deletes and redirects', function (): void {
    $application = Application::factory()->create();

    $response = delete(route('applications.destroy', $application));

    $response->assertRedirect(route('applications.index'));

    assertSoftDeleted($application);
});
