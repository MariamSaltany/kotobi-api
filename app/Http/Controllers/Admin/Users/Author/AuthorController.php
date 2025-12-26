<?php

namespace App\Http\Controllers\Admin\Users\Author;

use App\Models\User;
use App\Eunms\User\UserType;
use App\Eunms\User\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\Author\StoreAuthorRequest;
use App\Http\Resources\Admin\Users\Author\AuthorResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $authors = User::query()
            ->where('type', UserType::Author)
            ->with(['author', 'photo'])
            ->when($request->search, function ($query, $search) {
                $query->searchByName($search);
            })
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15);
        return $this->sendResponse(
            AuthorResource::collection($authors)->response()->getData(true),
            'Authors retrieved successfully.'
        );
    }

    /**
     * Admin creating an Author directly
     */
    public function store(StoreAuthorRequest $request)
    {
        $validatedData = $request->validated();
        
        try {
                DB::beginTransaction();
                $user = User::create([
                    'username' => $validatedData['username'],
                    'first_name'     => $validatedData['first_name'],
                    'last_name'     => $validatedData['last_name'],
                    'password' => $validatedData['password'],
                    'type'     => UserType::Author,
                    'status'   => UserStatus::Active,
                ]);

                $user->author()->create([
                    'bio' => $validatedData['bio'] ?? null,
                    'country' => $validatedData['country'] ?? null,
                ]);
                
                if ($request->hasFile('photo')) {
                    $file = $request->file('photo');
                    $path = $file->store('authors/avatars', 'public');

                $user->photo()->create([
                    'file_path'  => $path,
                    'file_name'  => $request->file('photo')->getClientOriginalName(),
                    'mime_type'  => $request->file('photo')->getMimeType(),
                    'size'       => $request->file('photo')->getSize(),
                    'collection' => 'avatar',
                ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        return $this->sendResponse(
                 AuthorResource::make($user->load(['author', 'photo'])),
                'Author created successfully.',
                201
            );
    }

    public function approve(User $user)
    {
        if ($user->type !== UserType::Author || $user->status !== UserStatus::Pending) {
            return response()->json(['message' => 'User is not a pending author.'], 422);
        }
        
        $user->update(['status' => UserStatus::Active]);
        return $this->sendResponse(null, "Author '{$user->username}' has been approved.");
    }

    public function block(User $user)
    {
        if ($user->status === UserStatus::Blocked) {
            return response()->json(['message' => 'User is already blocked.'], 422);
        }

        $user->update(['status' => UserStatus::Blocked]);
        return $this->sendResponse(null, "Author '{$user->username}' has been blocked.");
    }
}
