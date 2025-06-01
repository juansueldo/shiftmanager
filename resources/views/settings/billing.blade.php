<div class="container-xxl flex-grow-1 container-p-y">
    <h3>{{__('user.account')}} <span class="text-muted text-small"> {{ __('user.span_account') }}</span></h3>
<div class="card mb-4">
                    <!-- Billing Address -->
                    <h5 class="card-header">Billing Address</h5>
                    <div class="card-body">
                      <form id="formAccountSettings" onsubmit="return false" class="fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                        <div class="row">
                          <div class="mb-3 col-sm-6 fv-plugins-icon-container">
                            <label for="companyName" class="form-label">Company Name</label>
                            <input type="text" id="companyName" name="companyName" class="form-control" placeholder="Pixinvent" value="{{ $customer['company_name'] }}">
                          <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                          <div class="mb-3 col-sm-6 fv-plugins-icon-container">
                            <label for="billingEmail" class="form-label">Billing Email</label>
                            <input class="form-control" type="text" id="billingEmail" name="billingEmail" placeholder="john.doe@example.com" value="{{ $customer['company_email'] }}">
                          <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                          <div class="mb-3 col-sm-6">
                            <label for="taxId" class="form-label">Tax ID</label>
                            <input type="text" id="taxId" name="taxId" class="form-control" placeholder="Enter Tax ID">
                          </div>
                          <div class="mb-3 col-sm-6">
                            <label for="vatNumber" class="form-label">VAT Number</label>
                            <input class="form-control" type="text" id="vatNumber" name="vatNumber" placeholder="Enter VAT Number">
                          </div>
                          <div class="mb-3 col-sm-6">
                            <label for="mobileNumber" class="form-label">Mobile</label>
                            <div class="input-group input-group-merge">
                              <span class="input-group-text">US (+1)</span>
                              <input class="form-control mobile-number" type="text" id="mobileNumber" name="mobileNumber" placeholder="202 555 0111" value="{{$customer['company_phone']}}" maxlength="10">
                            </div>
                          </div>
                          <div class="mb-3 col-sm-6">
                            <label for="country" class="form-label">Country</label>
                            <div class="position-relative"><select id="country" class="form-select select2 select2-hidden-accessible" name="country" data-select2-id="country" tabindex="-1" aria-hidden="true">
                              <option selected="" data-select2-id="2">USA</option>
                              <option>Canada</option>
                              <option>UK</option>
                              <option>Germany</option>
                              <option>France</option>
                            </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="1" style="width: 485.5px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-country-container"><span class="select2-selection__rendered" id="select2-country-container" role="textbox" aria-readonly="true" title="USA">USA</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span></div>
                          </div>
                          <div class="mb-3 col-12">
                            <label for="billingAddress" class="form-label">Billing Address</label>
                            <input type="text" class="form-control" id="billingAddress" name="billingAddress" placeholder="Billing Address">
                          </div>
                          <div class="mb-3 col-sm-6">
                            <label for="state" class="form-label">State</label>
                            <input class="form-control" type="text" id="state" name="state" placeholder="California">
                          </div>
                          <div class="mb-3 col-sm-6">
                            <label for="zipCode" class="form-label">Zip Code</label>
                            <input type="text" class="form-control zip-code" id="zipCode" name="zipCode" placeholder="231465" maxlength="6">
                          </div>
                        </div>
                        <div class="mt-2">
                          <button type="submit" class="btn btn-primary me-2 waves-effect waves-light">Save changes</button>
                          <button type="reset" class="btn btn-label-secondary waves-effect">Discard</button>
                        </div>
                      <input type="hidden"></form>
                    </div>
                    <!-- /Billing Address -->
                  </div>
                  </div>