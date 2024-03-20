@extends('layouts.main')

@section('content')
    <div class="row justify-content-center align-items-center" style="height: 100%;">
        <div class="col-md-6">
            <form class="needs-validation" novalidate action="{{ action('WidgetController@create') }}" method="POST"
                role="form">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="validationTooltip01">Name</label>
                        <input type="text" class="form-control" id="validationTooltip01" name="name"
                            placeholder="Name" value="" required>
                        <div class="invalid-tooltip">
                            Please provide a valid name.
                        </div>
                    </div>

                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="validationTooltip03">Color</label>
                        <input type="text" class="form-control" id="validationTooltip03" name="color"
                            placeholder="Color" required>
                        <div class="invalid-tooltip">
                            Please provide a valid color.
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="validationTooltip03">Description (optional)</label>
                        <input type="text" class="form-control" id="validationTooltip03" name="description"
                            placeholder="Description">
                    </div>
                </div>
                <button class="btn btn-dark" type="submit">Submit</button>
            </form>
        </div>
        @if (isset($widgets) && count($widgets))
            <div class="col-md-6">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Color</th>
                            <th scope="col">Description</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($widgets as $widget)
                            <tr id="widget-id-{{ $widget->id }}">
                                <th scope="row">{{ $widget->id }}</th>
                                <td>{{ $widget->name }}</td>
                                <td>{{ $widget->color }}</td>
                                <td>{{ $widget->description }}</td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-secondary" id="widget-edit-{{ $widget->id }}"
                                            onclick='update({{ json_encode($widget) }})'>Edit</button>
                                        <button class="btn btn-sm btn-danger ml-2"
                                            onclick="deleteWidget('{{ $widget->id }}')">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        {{ $widgets->links() }}
                    </ul>
                </nav>
            </div>
        @endif
    </div>
@endsection
