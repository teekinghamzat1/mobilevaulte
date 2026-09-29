<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class SecurityQuestionController extends Controller
{
    /**
     * Update security question configuration for a user.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'security_question_enabled' => 'required|in:0,1',
            'security_question' => 'nullable|string|max:255',
            'security_answer' => 'nullable|string|max:255',
        ]);

        $enabled = (bool) $request->security_question_enabled;

        // If enabled, question and answer must be present
        if ($enabled) {
            if (empty($request->security_question) || empty($request->security_answer)) {
                return redirect()->back()->with('message', 'Both Security Question and Answer are required when enabling security questions.');
            }

            $user->security_question_enabled = true;
            $user->security_question = trim($request->security_question);
            $user->security_answer = trim($request->security_answer);
        } else {
            $user->security_question_enabled = false;
            // Retain question and answer optionally or update if provided
            if (!empty($request->security_question)) {
                $user->security_question = trim($request->security_question);
            }
            if (!empty($request->security_answer)) {
                $user->security_answer = trim($request->security_answer);
            }
        }

        $user->save();

        $statusText = $enabled ? 'enabled' : 'disabled';
        return redirect()->back()->with('success', "Security questions {$statusText} successfully for {$user->name}!");
    }
}
