<?php

use App\Models\Notification;
use App\Models\Report;
use App\Models\User;

test('new reports notify the reported user with a response link', function () {
    $reporter = User::factory()->create();
    $reportedUser = User::factory()->create();

    $this->actingAs($reporter)
        ->post(route('reports.store'), [
            'reported_user_id' => $reportedUser->id,
            'reason' => 'Other',
            'details' => 'A report detail.',
        ])
        ->assertSessionHasNoErrors();

    $report = Report::where('reporter_id', $reporter->id)->firstOrFail();
    $notification = Notification::where('user_id', $reportedUser->id)->where('type', 'report_response')->firstOrFail();

    expect($notification->url)->toBe(route('reports.respond.form', $report));
});

test('reported user can submit a report response and it is added to the report ticket', function () {
    $reporter = User::factory()->create();
    $reportedUser = User::factory()->create();
    $report = Report::create([
        'reporter_id' => $reporter->id,
        'reported_user_id' => $reportedUser->id,
        'reason' => 'Other',
        'status' => 'Pending',
    ]);

    $this->actingAs($reportedUser)
        ->get(route('reports.respond.form', $report))
        ->assertOk();

    $this->actingAs($reportedUser)
        ->post(route('reports.respond', $report), [
            'reported_user_response' => 'I would like to explain what happened.',
        ])
        ->assertRedirect(route('chat.index'));

    expect($report->fresh()->reported_user_response)->toBe('I would like to explain what happened.')
        ->and($report->fresh()->status)->toBe('Reviewed')
        ->and(Notification::where('user_id', $reporter->id)->where('type', 'report_response')->exists())->toBeTrue();
});

test('only the reported user can view the response form', function () {
    $report = Report::create([
        'reporter_id' => User::factory()->create()->id,
        'reported_user_id' => User::factory()->create()->id,
        'reason' => 'Other',
        'status' => 'Pending',
    ]);

    $this->actingAs(User::factory()->create())
        ->get(route('reports.respond.form', $report))
        ->assertForbidden();
});
