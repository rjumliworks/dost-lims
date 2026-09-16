<?php

namespace App\Http\Controllers\Major;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Major\Sample\TemplateClass;

class SampleTemplateController extends Controller
{
    protected TemplateClass $template;

    public function __construct(TemplateClass $template){
        $this->template = $template;
    }

    public function index(Request $request){
        return $this->template->list($request);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:150',
            'customer_description' => 'nullable|string',
            'description' => 'nullable|string',
            'sampletype_id' => 'required|exists:sample_types,id',
        ]);

        return $this->template->save($request);
    }

    public function destroy($id){
        $this->template->delete($id);
        return response()->noContent();
    }
}
