<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class FooterController extends Controller
{
    public function report_create()
    {
        return view('footer.report');
    }

    public function report_store(Request $request)
    {
        $inputs = $request->validate([
            'report_type' => 'required|string',
            'manga_name' => 'nullable|string',
            'chapter_number' => 'nullable|string',
            'comment_id' => 'nullable|string',
            'report_scope' => 'required|string',
            'content' => 'required|string',
        ]);

        $report = new Report();
        $report->type = $inputs['report_type'];
        $report->manga_name = $inputs['manga_name'];
        $report->chapter_number = $inputs['chapter_number'];
        $report->comment_id = $inputs['comment_id'];
        $report->report_scope = $inputs['report_scope'];
        $report->content = $inputs['content'];
        $report->save();

        return back()->with('message', 'Report submitted successfully.');
    }

    public function cookie()
    {
        return view('footer.cookie');
    }

    public function privacy()
    {
        return view('footer.privacy');
    }

    public function terms()
    {
        return view('footer.terms');
    }

    public function copyright()
    {
        return view('footer.copyright');
    }

    public function content()
    {
        return view('footer.content');
    }

    public function community()
    {
        return view('footer.community');
    }

    public function advertising()
    {
        return view('footer.advertising');
    }

    public function claim()
    {
        return view('footer.claim');
    }
    
}
