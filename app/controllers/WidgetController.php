<?php 

class WidgetController extends BaseController
{
    public function index()
    {
        $widgets = Widget::paginate(10);
        return View::make('widgets.index', ['widgets' => $widgets]);
    }

    public function create()
    {
        $input = Input::all();
        Widget::create($input);
        return Redirect::route('widgets')->with('message', 'widget created successfully');
    }

    public function update($id)
    {
        $input = Input::all();
        $widget = Widget::where('id', $id)->firstOrFail();
        $widget->update($input);
        return Response::json($input);
    }

    public function destroy($id) 
    {
        $widget = Widget::where('id', $id)->firstOrFail();
        $widget->delete();
        return Response::json(['message' => 'Widget removed successfully']);
    }
}

?>