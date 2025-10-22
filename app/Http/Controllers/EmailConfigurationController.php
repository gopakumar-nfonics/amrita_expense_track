<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EmailConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmailConfigurationController extends Controller
{
    /**
     * Display a listing of email configurations.
     */
    public function index()
    {
        $emailConfigs = EmailConfiguration::where('is_active', true)
                                         ->orderBy('email_type')
                                         ->orderBy('created_at', 'desc')
                                         ->get();
        
        return view('email-config.index', compact('emailConfigs'));
    }

    /**
     * Show the form for creating a new email configuration.
     */
    public function create()
    {
        return view('email-config.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_type' => 'required|string|max:255',
            'email_address' => 'required|email|max:255',
            'recipient_name' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        EmailConfiguration::create([
            'email_type' => $request->email_type,
            'email_address' => $request->email_address,
            'recipient_name' => $request->recipient_name,
            'is_active' => $request->input('is_active', true), // Default to true (active)
        ]);

        return redirect()->route('email-config.index')
            ->with('success', 'Email configuration added successfully!');
    }

    /**
     * Display the specified email configuration.
     */
    public function show(EmailConfiguration $emailConfiguration)
    {
        return view('email-config.show', compact('emailConfiguration'));
    }

    /**
     * Show the form for editing the specified email configuration.
     */
    public function edit(EmailConfiguration $emailConfiguration)
    {
        return view('email-config.edit', compact('emailConfiguration'));
    }

    /**
     * Update the specified email configuration.
     */
    public function update(Request $request, EmailConfiguration $emailConfiguration)
    {
        $validator = Validator::make($request->all(), [
            'email_type' => 'required|string|max:255',
            'email_address' => 'required|email|max:255',
            'recipient_name' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $emailConfiguration->update([
            'email_type' => $request->email_type,
            'email_address' => $request->email_address,
            'recipient_name' => $request->recipient_name,
            'is_active' => $request->input('is_active', $emailConfiguration->is_active),
        ]);

        return redirect()->route('email-config.index')
            ->with('success', 'Email configuration updated successfully!');
    }

    /**
     * Remove the specified email configuration (soft delete by setting is_active to false).
     */
    public function destroy(EmailConfiguration $emailConfiguration)
    {
        $emailConfiguration->update(['is_active' => false]);

        return redirect()->route('email-config.index')
            ->with('success', 'Email configuration deactivated successfully!');
    }

    /**
     * Toggle active status of email configuration
     */
    public function toggleStatus(EmailConfiguration $emailConfiguration)
    {
        $emailConfiguration->update([
            'is_active' => !$emailConfiguration->is_active
        ]);

        $status = $emailConfiguration->is_active ? 'activated' : 'deactivated';
        
        return back()->with('success', "Email configuration {$status} successfully!");
    }

    /**
     * Get email configurations by type (AJAX)
     */
    public function getByType(Request $request)
    {
        $type = $request->get('type');
        $configs = EmailConfiguration::active()->byType($type)->get();
        
        return response()->json($configs);
    }
}
