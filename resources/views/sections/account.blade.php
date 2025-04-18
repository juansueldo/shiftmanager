<div class="container-xxl flex-grow-1 container-p-y">
    <h3>Account<span class="text-muted text-small"> / All information of your account</span></h3>
              <div class="row">
                <div class="col-md-12">
                    
                  <div class="card mb-6">
                    <!-- Account -->
                    <div class="card-body">
                      <div class="d-flex align-items-start align-items-sm-center gap-6">
                        <img
                          src="{{ asset($user->avatar) }}"
                          alt="user-avatar"
                          class="d-block w-px-100 h-px-100 rounded"
                          id="uploadedAvatar" />
                        <div class="button-wrapper">
                          <label for="upload" class="btn btn-sm btn-primary me-3 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Upload new photo</span>
                            <i class="ri-upload-2-line d-block d-sm-none"></i>
                            <input
                              type="file"
                              id="upload"
                              class="account-file-input"
                              hidden
                              accept="image/png, image/jpeg" />
                          </label>
                          <button type="button" id="resetImage" class="btn btn-sm btn-outline-danger account-image-reset mb-4">
                            <i class="ri-refresh-line d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Reset</span>
                          </button>

                          <div>Allowed JPG, GIF or PNG. Max size of 800K</div>
                        </div>
                      </div>
                    </div>
                    <div class="card-body pt-0">
                      <form id="formAccountSettings" 
                          class="form-floating" 
                          data-ajax-validated="true"
                          data-ajax-source="/account/update" 
                          data-ajax-method="replaceHtml"
                          data-ajax-container="span#content-wrapper"
                          data-ajax-then="updateNavbar"
                          >
                          @csrf
                          <input type="hidden" name="id" id="id" value="{{ $user->id }}">
                          <input type="hidden" name="avatar" id="avatar">
                        <div class="row mt-1 g-5">
                          <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                              <input
                                class="form-control"
                                type="text"
                                id="firstname"
                                name="firstname"
                                autofocus 
                                value="{{ $user->firstname }}"/>
                              <label for="firstname">First Name</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                              <input class="form-control" type="text" name="lastname" id="lastname" value="{{$user->lastname}}" />
                              <label for="lastname">Last Name</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                              <input
                                class="form-control"
                                type="text"
                                id="email"
                                name="email"
                                value="{{$user->email}}"
                                placeholder="john.doe@example.com" />
                              <label for="email">E-mail</label>
                            </div>
                          </div>
                          
                          <div class="col-md-6 form-password-toggle">
                            <div class="input-group input-group-merge ">
                              <div class="form-floating form-floating-outline">
                                <input
                                  type="password"
                                  id="password"
                                  name="password"
                                  class="form-control"
                                  placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" 
                                  />
                                <label for="password">Password</label>
                              </div>
                              <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line ri-20px"></i></span>
                            </div>
                          </div>
                        </div> 
                        <div class="mt-6">
                          <button type="submit" class="btn btn-primary me-3">Save changes</button>
                          <button type="reset" class="btn btn-outline-secondary">Reset</button>
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>
                  <div class="card">
                    <h5 class="card-header">Delete Account</h5>
                    <div class="card-body">
                      <form id="formAccountDeactivation" onsubmit="return false">
                        <div class="form-check mb-6 ms-3">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            name="accountActivation"
                            id="accountActivation" />
                          <label class="form-check-label" for="accountActivation"
                            >I confirm my account deactivation</label
                          >
                        </div>
                        <button type="submit" class="btn btn-danger deactivate-account" disabled="disabled">
                          Deactivate Account
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @include('layouts.partials.alert', ['session'=> $session ?? ''])
            <script>
              $(document).ready(function(){
                const originalAvatarUrl = "{{ asset($user->avatar) }}";
                uploadFile($('#upload'), $('#uploadedAvatar'), $('#avatar'));
                resetFile($('#resetImage'),$('#uploadedAvatar'), $('#avatar'), originalAvatarUrl)
              });

            </script>