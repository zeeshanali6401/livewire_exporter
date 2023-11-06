<div class="container mb-5">
    <div class="d-flex">
        <div class="m-5">
            <form wire:submit.prevent="import" enctype="multipart/form-data">
                <div class="input-group">
                    <input type="file" class="form-control" name="file" wire:model="file" id="inputGroupFile04"
                        aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                    <button type="submit" class="btn btn-outline-primary" type="button"
                        id="inputGroupFileAddon04">Import</button>
                </div>
            </form>
        </div>
        <button type="button" class="btn btn-outline-primary m-5" wire:click="export">Export</button>
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
                        <td class="font-monospace text-center">{{ $item->auth_key }}
                            <button wire:click="qr({{ $item->id }})" class="btn btn-secondary btn-sm">Qr</button>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-primary btn-sm"
                                wire:click="edit({{ $item->id }})"><i class="bi bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger btn-sm"
                                wire:click="dltModalShow({{ $item->id }})"><i class="bi bi-trash"></i></button>
                            <button type="button" wire:click="showConfirmMailModal({{ $item->id }})"
                                class="btn btn-info btn-sm"><i class="bi bi-check"></i></button>
                            <button type="button" wire:click="rejectMailModal({{ $item->id }})"
                                class="btn btn-warning btn-sm"><i class="bi bi-x"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $collection->links() }}
    </div>

    <!-- Edit User Modal -->
    <div wire:ignore.self class="modal fade" id="userEditModal" tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
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
                            <input type="text" class="form-control" wire:model="auth_key" aria-describedby="helpId"
                                @readonly(true) placeholder="Edit Email">
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
                <div class="modal-body text-center">
                    <button type="button" class="btn btn-danger" wire:click="delete">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mail Confirmation Modal -->
    <div class="modal fade" id="confirmationMail" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="confirmationMailLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title text-primary fs-5" id="confirmationMailLabel">Are You Sure to delete?
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:loading.attr="disabled" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <button type="button" class="btn btn-secondary" wire:loading.attr="disabled" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:loading.attr="disabled" wire:click="confirm">Accept</button>
                </div>
            </div>
        </div>
    </div>

    <!-- QR Modal -->
    <div class="modal fade" id="QrModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="QrModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title text-success fs-5" id="QrModalLabel">{{ $QR }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:loading.attr="disabled" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    @if (!is_null($QR))
                        {!! QrCode::size(200)->generate($QR); !!}
                    @endif
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Reject Mail Confirmation Modal -->
    <div class="modal fade" id="rejectMail" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="rejectMailLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title text-danger fs-5" id="rejectMailLabel">Are You Sure to delete?
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:loading.attr="disabled" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <button type="button" class="btn btn-secondary" wire:loading.attr="disabled" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" wire:loading.attr="disabled" wire:click="reject">Reject</button>
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
        window.addEventListener('showConfirmMailModal', event => {
            $("#confirmationMail").modal("show");
        })
        window.addEventListener('rejectMailModal', event => {
            $("#rejectMail").modal("show");
        })
        window.addEventListener('showQrModal', event => {
            $("#QrModal").modal("show");
        })
        window.addEventListener('hideModal', event => {
            console.log('ok');
            $("#userDeleteModal").modal("hide");
            $("#userEditModal").modal("hide");
            $("#confirmationMail").modal("hide");
            $("#rejectMail").modal("hide");
        })
    </script>
