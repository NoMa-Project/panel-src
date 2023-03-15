<h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
    {{ __('Delete Account') }}
</h2>

<p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
</p>


<button data-toggle="modal" data-target="#deleteAccount" class="btn btn-danger"> {{ __('Delete Account') }}</button>


<div class="modal fade" id="deleteAccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Are you sure you want to delete your account?') }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>

                    <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                        @csrf
                        @method('delete')
                
                        <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                
                        <x-text-input id="password" name="password" type="password" class="form-control mb-3" placeholder="{{ __('Password') }}"/>
                
                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger"  href="login.html">Logout</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
