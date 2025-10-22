<?php

namespace App\Http\Controllers\Api\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\ContactRequest;
use App\Http\Resources\Contact\ContactResource;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Contact\UpdateContactRequest;

class ContactController extends Controller
{
    public function index(): JsonResponse
    {
        $contacts = Contact::latest()->get();
        return response()->json(ContactResource::collection($contacts));
    }

    public function store(ContactRequest $request): JsonResponse
    {
        $contact = Contact::create($request->validated());
        return response()->json(new ContactResource($contact), 201);
    }

    public function show(Contact $contact): JsonResponse
    {
        return response()->json(new ContactResource($contact));
    }

    public function update(UpdateContactRequest $request, Contact $contact): JsonResponse
    {
        $contact->update($request->validated());
        return response()->json(new ContactResource($contact));
    }

    public function destroy(Contact $contact): JsonResponse
    {
        $contact->delete();
        return response()->json(['message' => 'Contact deleted successfully']);
    }
}
