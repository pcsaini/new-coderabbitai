<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Handles deposit request
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function deposit(Request $request): RedirectResponse
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1'
        ], [
            'amount.required' => 'Please enter amount',
            'amount.numeric' => 'Please enter valid amount',
            'amount.min' => 'Please enter greater than 0',
        ]);

        // Redirect back with error message if validation fails
        if ($validator->fails()) {
            return back()->with(['error' => $validator->errors()->first()])->withInput($request->all());
        }

        // Get the authenticated user
        $user = $request->user();
        try {
            // Start database transaction
            DB::beginTransaction();

            // Create a new transaction record
            $user->transactions()->create([
                'amount' => $request->get('amount'),
                'type' => Transaction::CREDIT,
                'description' => 'Deposit',
                'balance' => $user->balance + $request->get('amount')
            ]);

            // Update user balance
            $user->update([
                'balance' => $user->balance + $request->get('amount')
            ]);

            // Commit the database transaction
            DB::commit();
        } catch (Exception $exception) {
            // Rollback the database transaction in case of exception
            DB::rollBack();
            // Log the error
            Log::error('Deposit failed: ' . $exception->getMessage());
            // Redirect back with error message
            return back()->with(['error' => 'Whoops! Something went wrong. Please try again later.'])->withInput($request->all());
        }

        // Redirect back with success message
        return back()->with(['success' => 'Deposit successful']);
    }

    /**
     * Handles withdraw request
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function withdraw(Request $request): RedirectResponse
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1'
        ], [
            'amount.required' => 'Please enter amount',
            'amount.numeric' => 'Please enter valid amount',
            'amount.min' => 'Please enter greater than 0',
        ]);

        // Redirect back with error message if validation fails
        if ($validator->fails()) {
            return back()->with(['error' => $validator->errors()->first()])->withInput($request->all());
        }

        // Get the authenticated user
        $user = $request->user();
        try {
            // Start database transaction
            DB::beginTransaction();

            // Create a new transaction record
            $user->transactions()->create([
                'amount' => $request->get('amount'),
                'type' => Transaction::DEBIT,
                'description' => 'Withdraw',
                'balance' => $user->balance - $request->get('amount')
            ]);

            // Update user balance
            $user->update([
                'balance' => $user->balance - $request->get('amount')
            ]);

            // Commit the database transaction
            DB::commit();
        } catch (Exception $exception) {
            // Rollback the database transaction in case of exception
            DB::rollBack();
            // Log the error
            Log::error('Withdraw failed: ' . $exception->getMessage());
            // Redirect back with error message
            return back()->with(['error' => 'Whoops! Something went wrong. Please try again later.'])->withInput($request->all());
        }

        // Redirect back with success message
        return back()->with(['success' => 'Withdraw successful']);
    }

    /**
     * Transfer the specified amount from the authenticated user to the specified recipient.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function transfer(Request $request): RedirectResponse
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'email' => 'required|email|exists:users,email'
        ], [
            'amount.required' => 'Please enter amount',
            'amount.numeric' => 'Please enter valid amount',
            'amount.min' => 'Please enter greater than 0',
            'email.required' => 'Please enter email',
            'email.email' => 'Please enter valid email',
            'email.exists' => 'Sorry! User with this email does not exist',
        ]);

        // Redirect back with error message if validation fails
        if ($validator->fails()) {
            return back()->with(['error' => $validator->errors()->first()])->withInput($request->all());
        }

        // Get the authenticated user
        $user = $request->user();
        $receiver = User::where('email', $request->email)->first();

        if ($user->balance < $request->get('amount')) {
            return back()->with(['error' => 'Insufficient funds for transfer'])->withInput($request->all());
        }

        try {
            // Start database transaction
            DB::beginTransaction();

            // Create a new transaction record for the authenticated user
            $user->transactions()->create([
                'amount' => $request->get('amount'),
                'type' => Transaction::DEBIT,
                'description' => 'Transfer to ' . $receiver->email,
                'balance' => $user->balance - $request->get('amount')
            ]);

            // Create a new transaction record for the recipient
            $receiver->transactions()->create([
                'amount' => $request->get('amount'),
                'type' => Transaction::CREDIT,
                'description' => 'Received from ' . $user->email,
                'balance' => $receiver->balance + $request->get('amount')
            ]);

            // Update user balance by debiting the amount
            $user->update([
                'balance' => $user->balance - $request->get('amount')
            ]);

            // Update recipient balance by crediting the amount
            $receiver->update([
                'balance' => $receiver->balance + $request->get('amount')
            ]);

            // Commit the database transaction
            DB::commit();
        } catch (Exception $exception) {
            // Rollback the database transaction in case of exception
            DB::rollBack();
            // Log the error
            Log::error('Transfer failed: ' . $exception->getMessage());
            // Redirect back with error message
            return back()->with(['error' => 'Whoops! Something went wrong. Please try again later.'])->withInput($request->all());
        }

        // Redirect back with success message
        return back()->with(['success' => 'Transfer successful']);
    }

    /**
     * Display the user's transaction statement.
     *
     * @param Request $request
     * @return View|Application|Factory
     */
    public function statement(Request $request): View|Application|Factory
    {
        // Get the authenticated user
        $user = $request->user();

        // Retrieve the user's transactions, ordered by created_at in descending order, and paginate the results
        $transactions = $user->transactions()->orderBy('created_at', 'desc')->paginate(5);

        // Return the view with the transactions data
        return view('pages.statement', compact('transactions'));
    }
}
