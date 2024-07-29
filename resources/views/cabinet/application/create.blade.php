@extends('layouts.layoutMaster')

@section('title', 'eCommerce Product Add - Apps')

@section('vendor-style')
    @vite([
      'resources/assets/vendor/libs/quill/typography.scss',
      'resources/assets/vendor/libs/quill/katex.scss',
      'resources/assets/vendor/libs/quill/editor.scss',
      'resources/assets/vendor/libs/select2/select2.scss',
      'resources/assets/vendor/libs/dropzone/dropzone.scss',
      'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
      'resources/assets/vendor/libs/tagify/tagify.scss',
      'resources/assets/vendor/libs/dropzone/dropzone.scss'
    ])
@endsection

@section('vendor-script')
    @vite([
      'resources/assets/vendor/libs/quill/katex.js',
      'resources/assets/vendor/libs/quill/quill.js',
      'resources/assets/vendor/libs/select2/select2.js',
      'resources/assets/vendor/libs/dropzone/dropzone.js',
      'resources/assets/vendor/libs/jquery-repeater/jquery-repeater.js',
      'resources/assets/vendor/libs/flatpickr/flatpickr.js',
      'resources/assets/vendor/libs/tagify/tagify.js',
      'resources/assets/vendor/libs/dropzone/dropzone.js'
    ])
@endsection


@section('page-script')
    @vite([
      'resources/assets/js/app-ecommerce-product-add.js',
    ])
@endsection

@section('content')
    <form action="{{route('application.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="app-ecommerce">


            <!-- Add Product -->
            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">

                <div class="d-flex flex-column justify-content-center">
                    <h4 class="mb-1">Add a new Application</h4>
                </div>
                <div class="d-flex align-content-center flex-wrap gap-4">
                    <div class="d-flex gap-4">
                        <a class="btn btn-label-secondary" href="{{route('dashboard')}}">Discard</a>
                    </div>
                    <button type="submit" class="btn btn-primary">Publish application</button>
                </div>

            </div>

            <div class="row">

                <!-- First column-->
                <div class="col-12 col-lg-10 ">
                    <!-- Product Information -->
                    <div class="card mb-6">
                        <div class="card-header">
                            <h5 class="card-tile mb-0">Application information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-6">
                                <label class="form-label" for="ecommerce-product-name">1. Ariza beruvchining nomi (yuridik shaxs — tashkilot nomi) *</label>
                                @if($errors->has('name'))
                                    <div class="alert alert-danger">
                                        {{$errors->first('name')}}
                                    </div>
                                @endif
                                <input type="text" class="form-control" id="ecommerce-product-name"
                                       placeholder="Name" name="name" aria-label="Name">

                            </div>
                            <div class="mb-6">
                                <label class="form-label" for="ecommerce-product-name"> 2. Manzili/Joylashgan joyi (pochta manzili)</label>
                                @if($errors->has('address'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('address')}}
                                    </div>
                                @endif
                                <input type="text" class="form-control" id="ecommerce-product-name"
                                       placeholder="address" name="address" aria-label="Name">
                            </div>
                            <div class="mb-6">
                                <label class="form-label" for="ecommerce-product-name"> 3. KTUT, STIR, IFUT kodi</label>
                                @if($errors->has('tin'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('tin')}}
                                    </div>
                                @endif
                                <input type="text" class="form-control" id="ecommerce-product-name"
                                       placeholder="tin" name="tin" aria-label="Name">
                            </div>
                            <div class="mb-6">
                                <label class="form-label" for="ecommerce-product-name"> 4. Telefon raqami</label>
                                @if($errors->has('phone'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('phone')}}
                                    </div>
                                @endif
                                <input type="text" class="form-control" id="ecommerce-product-name"
                                       placeholder="phone" name="phone" aria-label="Name">
                            </div>
                            <div class="mb-6">
                                <label class="form-label" for="ecommerce-product-name"> 5. Bank rekvizitlari</label>
                                @if($errors->has('bank_requisite'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('bank_requisite')}}
                                    </div>
                                @endif
                                <input type="text" class="form-control" id="ecommerce-product-name"
                                       placeholder="bank_requisite" name="bank_requisite" aria-label="Name">
                            </div>
                            <div class="mb-6">
                                <label class="form-label" for="ecommerce-product-name"> 6. Olib kelinayotgan brend nomi</label>
                                @if($errors->has('brand_name'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('brand_name')}}
                                    </div>
                                @endif
                                <input type="text" class="form-control" id="ecommerce-product-name"
                                       placeholder="brand_name" name="brand_name" aria-label="Name">
                            </div>
                            <div>
                                <label class="mb-1">7. Ariza berilayotgan tovarning TIF TN bo‘yicha tasnif kodi haqida ma'lumot</label>
                                @if($errors->has('mxik'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('mxik')}}
                                    </div>
                                @endif
                                <textarea class="form-control" aria-label="With textarea" placeholder="mxik" name="mxik"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- /Product Information -->
                    <!-- Media -->
                    <div class="card mb-6">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 card-title">8. Xalqaro brendlar tovarlari ayrim turlarining brend egalari yoki ularning vakolatli yetkazib beruvchilari (rasmiy distribyutorlar, dilerlar, ishlab chiqaruvchilarning savdo vakillari va ularning distrib'yutorlari, lisenziatlari) ekanligini tasdiqlovchi rasmiy hujjatlar</h5>
                        </div>
                        @if($errors->has('official_documents'))
                            <div class="alert alert-danger" role="alert">
                                {{$errors->first('official_documents')}}
                            </div>
                        @endif
                        <div class="card-body">
                            <label for="formFile" class="form-label">20mb dan ko'p bo'lmagan fayl biriktiring</label>
                            <input class="form-control" type="file" id="formFile">
                        </div>
                    </div>
                    <div class="card mb-6">
                        <div class="card-header">
                            <label class="form-label" for="ecommerce-product-name"> 9. To‘g‘ridan-to‘g‘ri tuzilgan import shartnomalarining raqami va sanasi</label>
                        </div>
                        <div class="card-body">
                        @if($errors->has('contract_details'))
                            <div class="alert alert-danger" role="alert">
                                {{$errors->first('contract_details')}}
                            </div>
                        @endif
                        <input type="text" class="form-control" id="ecommerce-product-name"
                               placeholder="contract_details" name="contract_details" aria-label="Name">
                        </div>
                    </div>
                    <div class="card mb-6">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 card-title">10. Jahonning quyidagi mintaqalaridan kamida ikkitasi — Shimoliy Amerika, Yevropa, Yaqin Sharq, Sharqiy Osiyoning chakana savdo tarmog‘ida brend mahsulotlarining mavjudligini tasdiqlovchi hujjatlar</h5>
                        </div>
                        @if($errors->has('at_least_country_documents'))
                            <div class="alert alert-danger" role="alert">
                                {{$errors->first('at_least_country_documents')}}
                            </div>
                        @endif
                        <div class="card-body">
                            <form action="/upload" class="dropzone needsclick p-0" id="dropzone-second">
                                <div class="dz-message needsclick">
                                    <p class="h4 needsclick pt-3 mb-2">Drag and drop your image here</p>
                                    <p class="h6 text-muted d-block fw-normal mb-2">or</p>
                                    <span class="note needsclick btn btn-sm btn-label-primary"
                                          id="btnBrowse">Browse image</span>
                                </div>
                                <div class="fallback">
                                    <input name="at_least_country_documents" type="file"/>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div>
                        <label class="mb-1">11. Tovarning kelib chiqishi mamlakati va ishlab chiqaruvchisi haqida dastlabki ma'lumot (yuk bojxona hududiga kelib tushganda kelib chiqish sertifikati, eksport deklaratsiyasi va tranzit deklaratsiyasi (mavjud bo‘lsa) bilan tasdiqlanadi)</label>
                        @if($errors->has('manufactured_countries'))
                            <div class="alert alert-danger" role="alert">
                                {{$errors->first('manufactured_countries')}}
                            </div>
                        @endif
                        <textarea class="form-control" aria-label="With textarea" placeholder="manufactured_countries" name="manufactured_countries"></textarea>

                    </div>

                    <div class="card mb-6">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 card-title">12. Chakana savdoni amalga oshirish uchun moddiy-texnika bazasi mavjudligini tasdiqlovchi hujjatlar</h5>
                            <a href="javascript:void(0);" class="fw-medium">Add media from URL</a>
                        </div>
                        @if($errors->has('retail_documents'))
                            <div class="alert alert-danger" role="alert">
                                {{$errors->first('retail_documents')}}
                            </div>
                        @endif
                        <div class="card-body">
                            <form action="/upload" class="dropzone needsclick p-0" id="dropzone-second">
                                <div class="dz-message needsclick">
                                    <p class="h4 needsclick pt-3 mb-2">Drag and drop your image here</p>
                                    <p class="h6 text-muted d-block fw-normal mb-2">or</p>
                                    <span class="note needsclick btn btn-sm btn-label-primary"
                                          id="btnBrowse">Browse image</span>
                                </div>
                                <div class="fallback">
                                    <input name="retail_documents" type="file"/>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card mb-6">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 card-title">13. Xalqaro brendlar import qiluvchining tovarlarini realizasiya qilishi (savdo qilishi) uchun o‘zining yoki ijaraga olingan bino, inshoot ob'ekt(lar)i mavjudligi haqida ma'lumot</h5>
                        </div>
                        @if($errors->has('rent_building_documents'))
                            <div class="alert alert-danger" role="alert">
                                {{$errors->first('rent_building_documents')}}
                            </div>
                        @endif
                        <div class="card-body">
                            <form action="/upload" class="dropzone needsclick p-0" id="dropzone-basic">
                                <div class="dz-message needsclick">
                                    <p class="h4 needsclick pt-3 mb-2">Drag and drop your image here</p>
                                    <p class="h6 text-muted d-block fw-normal mb-2">or</p>
                                    <span class="note needsclick btn btn-sm btn-label-primary"
                                          id="btnBrowse">Browse image</span>
                                </div>
                                <div class="fallback">
                                    <input name="rent_building_documents" type="file"/>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card mb-6">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 card-title">14. Xalqaro distribyutorlik tarmoqlari mavjudligi haqida ma'lumot</h5>
                        </div>
                        @if($errors->has('distributor_documents'))
                            <div class="alert alert-danger" role="alert">
                                {{$errors->first('distributor_documents')}}
                            </div>
                        @endif
                        <div class="card-body">
                            <form action="/upload" class="dropzone needsclick p-0" id="dropzone-basic">
                                <div class="dz-message needsclick">
                                    <p class="h4 needsclick pt-3 mb-2">Drag and drop your image here</p>
                                    <p class="h6 text-muted d-block fw-normal mb-2">or</p>
                                    <span class="note needsclick btn btn-sm btn-label-primary"
                                          id="btnBrowse">Browse image</span>
                                </div>
                                <div class="fallback">
                                    <input name="distributor_documents" type="file"/>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card mb-6">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 card-title">15. Brendlar rasmiy internet saytlarining mavjudligi haqida ma'lumot</h5>
                        </div>
                        @if($errors->has('website_documents'))
                            <div class="alert alert-danger" role="alert">
                                {{$errors->first('website_documents')}}
                            </div>
                        @endif
                        <div class="card-body">
                            <form action="/upload" class="dropzone needsclick p-0" id="dropzone-basic">
                                <div class="dz-message needsclick">
                                    <p class="h4 needsclick pt-3 mb-2">Drag and drop your image here</p>
                                    <p class="h6 text-muted d-block fw-normal mb-2">or</p>
                                    <span class="note needsclick btn btn-sm btn-label-primary"
                                          id="btnBrowse">Browse image</span>
                                </div>
                                <div class="fallback">
                                    <input name="website_documents" type="file"/>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /Media -->

                </div>
                <!-- /Second column -->

            </div>

        </div>
    </form>

@endsection
