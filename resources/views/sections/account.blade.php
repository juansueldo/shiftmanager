<div class="container-xxl flex-grow-1 container-p-y">
    <h3>{{__('user.account')}} <span class="text-muted text-small"> {{ __('user.span_account') }}</span></h3>
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
                            <span class="d-none d-sm-block">{{ __('user.upload_photo') }}</span>
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
                            <span class="d-none d-sm-block">{{__('user.reset')}}</span>
                          </button>

                          <div>{{ __('user.allowed') }}</div>
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
                              <label for="firstname">{{__('user.firstname')}}</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                              <input class="form-control" type="text" name="lastname" id="lastname" value="{{$user->lastname}}" />
                              <label for="lastname">{{  __('user.lastname')}}</label>
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
                              <label for="email">{{ __('user.email') }}</label>
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
                                <label for="password">{{ __('user.password') }}</label>
                              </div>
                              <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line ri-20px"></i></span>
                            </div>
                          </div>
                        </div> 
                        <div class="mt-6">
                          <button type="submit" class="btn btn-primary me-3">{{__('user.save')}}</button>
                          <!--<button type="reset" class="btn btn-outline-secondary">Reset</button>-->
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>
                  <div class="card">
                    <h5 class="card-header">{{ __('user.delete_account') }}</h5>
                    <div class="card-body">
                      <form id="formAccountDeactivation" onsubmit="return false">
                        <div class="form-check mb-6 ms-3">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            name="accountActivation"
                            id="accountActivation" />
                          <label class="form-check-label" for="accountActivation"
                            >{{ __('user.delete_account_confirm') }}</label
                          >
                        </div>
                        <button type="submit" class="btn btn-danger deactivate-account" disabled="disabled">
                          {{__('user.deactivate_account')}}
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
                resetFile($('#resetImage'),$('#uploadedAvatar'), $('#avatar'), originalAvatarUrl);
              });

            </script>