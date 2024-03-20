<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Widget</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        form {
            width: 100%;
        }
    </style>

</head>

<body>
    <nav class="navbar navbar-dark bg-dark" style="height: 65px;">
        <a class="navbar-brand" href="#">Widget</a>
      </nav>
    <div class="container" style="height: 100vh;">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    @yield('scripts')
</body>

</html>
