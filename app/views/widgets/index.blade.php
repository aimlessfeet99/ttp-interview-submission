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

@section('scripts')
    <script>
        $('form').on('submit', function(event) {
            if (!this.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            $(this).addClass('was-validated');
        });

        @if (Session::get('message'))
            Swal.fire({
                title: "Widget",
                text: "{{ Session::get('message') }}",
                icon: "success"
            });
        @endif
    </script>
    <script>
        function deleteWidget(widgetID) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/api/widgets/' + widgetID, {
                            method: 'DELETE',
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            document.getElementById('widget-id-' + widgetID).style.display = 'none';
                            Swal.fire({
                                title: "Deleted!",
                                text: data.message,
                                icon: "success"
                            });
                        })
                        .catch(error => {
                            console.error('There was a problem with your fetch operation:', error);
                        });
                }
            });
        }

        function update(widget) {
            Swal.fire({
                title: "Edit Widget",
                html: `<div class="d-flex flex-column" style="gap: 10px; text-align: start;">
                    <div>
                        <label for="validationTooltip03">Name</label>
                        <input id="input-name" class="form-control" placeholder="name" value="${widget.name}">
                    </div>
                    <div>
                        <label for="validationTooltip02">Color</label>
                        <input id="input-color" class="form-control" placeholder="color" value="${widget.color}">
                    </div>
                    <div>
                        <label for="validationTooltip01">Description</label>
                        <input id="input-description" class="form-control" placeholder="description" value="${widget.description}">
                    </div>
                    </div>`,
                showCancelButton: true,
                confirmButtonText: "Update",
                preConfirm: async () => {
                    const name = document.getElementById('input-name').value
                    const color = document.getElementById('input-color').value
                    if(!name) {
                        return Swal.showValidationMessage(`
                            name is required
                        `);
                    }
                    if(!color) {
                        return Swal.showValidationMessage(`
                            color is required
                        `);
                    }
                    const payload = {
                        name: name,
                        color: color,
                        description: document.getElementById('input-description').value
                    }
                    try {
                        consUrl = `/api/widgets/${widget.id}`;
                        const response = await fetch(`/api/widgets/${widget.id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'accept': 'application/json'
                            },
                            body: JSON.stringify(payload)
                        });
                        if (!response.ok) {
                            return Swal.showValidationMessage(`
                            ${JSON.stringify(await response.json())}
                            `);
                        }
                        let row = document.getElementById('widget-id-'+widget.id)
                        const tds = row.querySelectorAll('td');

                        tds[0].innerText = payload.name
                        tds[1].innerText = payload.color
                        tds[2].innerText = payload.description

                        Swal.fire({
                            title: "Widget Updated!",
                            text: "widget updated successfully",
                            icon: "success"
                        });
                    } catch (error) {
                        Swal.showValidationMessage(`
                            Request failed: ${error}
                        `);
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const input1Value = result.value.input1;
                    const input2Value = result.value.input2;
                    
                }
            });
        }
    </script>
@endsection
