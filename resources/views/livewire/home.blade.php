<div class="container mb-5">
    <div class="d-flex">
        <div class="m-5">
            <form action="">
                <div class="input-group">
                    <input type="file" class="form-control" wire:model="file" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                    <button  wire:click="import" class="btn btn-outline-primary" type="button" id="inputGroupFileAddon04">Button</button>
                  </div>
            </form>
        </div>

        <button type="button" class="btn btn-primary m-5" wire:click="export">Export</button>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th class="text-center">Auth Key</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($collection as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td class="text-center">{{ $item->auth_key }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-primary btn-sm"
                                wire:click="edit({{ $item->id }})"><i class="bi bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger btn-sm"
                                wire:click="dltModalShow({{ $item->id }})"><i class="bi bi-trash"></i></button>
                            <button type="button" class="btn btn-info btn-sm"><i class="bi bi-check"></i></button>
                            <button type="button" class="btn btn-warning btn-sm"><i class="bi bi-x"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Edit User Modal -->
    <div wire:ignore.self class="modal fade" id="userEditModal" tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Modal title</h5>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="update">
                        <div class="mb-3">
                            <label for="" class="form-label">Name</label>
                            <input type="text" class="form-control" wire:model="name" aria-describedby="helpId"
                                placeholder="Edit Name">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Email</label>
                            <input type="text" class="form-control" wire:model="email" aria-describedby="helpId"
                                placeholder="Edit Email">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Auth Key</label>
                            <input type="text" class="form-control" wire:model="auth_key" aria-describedby="helpId" @readonly(true)
                                placeholder="Edit Email">
                        </div>
                        <div class="modal-footer">
                            <button type="button" wire:click="update" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="userDeleteModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="userDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title text-danger fs-5" id="userDeleteModalLabel">Are You Sure to delete?
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <button type="button" class="btn btn-danger" wire:click="delete">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('showModal', event => {
            $("#userDeleteModal").modal("show");
        })
        window.addEventListener('showEditModal', event => {
            $("#userEditModal").modal("show");
        })
        window.addEventListener('hideModal', event => {
            console.log('ok');
            $("#userDeleteModal").modal("hide");
            $("#userEditModal").modal("hide");
        })
    </script>
