<?php

namespace Tests\Unit;

use App\ContactSubmission;
use App\Http\Controllers\ContactController;
use App\Mail\Contact as ContactEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ViewErrorBag;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function testNameIsRequired()
    {
        $request = Request::create('/contact', 'POST', [
            'email'   => 'example@email.com',
            'phone'   => '1234567890',
            'message' => 'test'
        ]);

        $controller = new ContactController();
        $response = $controller->send($request);

        $this->assertTrue(is_a($response, RedirectResponse::class));

        /** @var ViewErrorBag $errors */
        $errors = $response->getSession()->get('errors');

        $this->assertTrue($errors->has('name'));
        $this->assertSame('The name field is required.', $errors->first('name'));
    }

    public function testEmailIsRequired()
    {
        $request = Request::create('/contact', 'POST', [
            'name'    => 'test name',
            'phone'   => '1234567890',
            'message' => 'test'
        ]);

        $controller = new ContactController();
        $response = $controller->send($request);

        $this->assertTrue(is_a($response, RedirectResponse::class));

        /** @var ViewErrorBag $errors */
        $errors = $response->getSession()->get('errors');

        $this->assertTrue($errors->has('email'));
        $this->assertSame('The email field is required.', $errors->first('email'));
    }

    public function testEmailMustBeValid()
    {
        $request = Request::create('/contact', 'POST', [
            'name'    => 'test name',
            'email'   => 'notanemail.com',
            'phone'   => '1234567890',
            'message' => 'test'
        ]);

        $controller = new ContactController();
        $response = $controller->send($request);

        $this->assertTrue(is_a($response, RedirectResponse::class));

        /** @var ViewErrorBag $errors */
        $errors = $response->getSession()->get('errors');

        $this->assertTrue($errors->has('email'));
        $this->assertSame('The email must be a valid email address.', $errors->first('email'));
    }

    public function testPhoneIsOptional()
    {
        $request = Request::create('/contact', 'POST', [
            'name'    => 'test name',
            'email'   => 'example@email.com',
            'phone'   => null,
            'message' => 'test'
        ]);

        $controller = new ContactController();
        $response = $controller->send($request);

        $this->assertTrue(is_a($response, RedirectResponse::class));

        /** @var ViewErrorBag $errors */
        $errors = $response->getSession()->get('errors');

        $this->assertNull($errors);
    }

    public function testPhoneMustBeValid()
    {
        $request = Request::create('/contact', 'POST', [
            'name'    => 'test name',
            'email'   => 'test@email.com',
            'phone'   => '12345abcdefg',
            'message' => 'test'
        ]);

        $controller = new ContactController();
        $response = $controller->send($request);

        $this->assertTrue(is_a($response, RedirectResponse::class));

        /** @var ViewErrorBag $errors */
        $errors = $response->getSession()->get('errors');

        $this->assertTrue($errors->has('phone'));
        $this->assertSame('The phone number must be a valid number.', $errors->first('phone'));
    }

    public function testMessageIsRequired()
    {
        $request = Request::create('/contact', 'POST', [
            'name'  => 'test name',
            'email' => 'test@email.com',
            'phone' => '1234567890'
        ]);

        $controller = new ContactController();
        $response = $controller->send($request);

        $this->assertTrue(is_a($response, RedirectResponse::class));

        /** @var ViewErrorBag $errors */
        $errors = $response->getSession()->get('errors');

        $this->assertTrue($errors->has('message'));
        $this->assertSame('The message field is required.', $errors->first('message'));
    }

    public function testEmailIsSent()
    {
        Mail::fake();

        $request = Request::create('/contact', 'POST', [
            'name'    => 'test name',
            'email'   => 'test@email.com',
            'phone'   => '1234567890',
            'message' => 'test'
        ]);

        $controller = new ContactController();
        $controller->send($request);

        Mail::assertSent(ContactEmail::class, function(ContactEmail $email) {
            return $email->hasTo('guy-smiley@example.com');
        });
    }

    public function testSubmissionIsStoredInTheDatabase()
    {
        $fields = [
            'name'    => 'test name',
            'email'   => 'test@email.com',
            'phone'   => '1234567890',
            'message' => 'test'
        ];
        $request = Request::create('/contact', 'POST', $fields);

        $controller = new ContactController();
        $controller->send($request);

        $this->assertCount(1, ContactSubmission::all());

        $submission = ContactSubmission::first();

        foreach ($fields as $field => $value) {
            $this->assertSame($value, $submission->$field);
        }
    }
}
