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
    <form action="{{route('application.update', ['application' => $application->id])}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="app-ecommerce">


            <!-- Add Product -->
            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">

                <div class="d-flex flex-column justify-content-center">
                    <h4 class="mb-1">Edit Application</h4>
                </div>
                <div class="d-flex align-content-center flex-wrap gap-4">
                    <div class="d-flex gap-4">
                        <a class="btn btn-label-secondary" href="{{route('application.index')}}">Discard</a>
                    </div>
                    <button type="submit" class="btn btn-primary">Edit application</button>
                </div>

            </div>

            <div class="row">

                <!-- First column-->
                <div class="col-12 col-lg-10 ">
                    <!-- Product Information -->
                    <div class="card mb-6">
                        <div class="card-header">
                            <h5 class="card-tile mb-0">Xalqaro brendlar tovarlarining ayrim turlarini brend egalari yoki
                                ularning vakolatli yetkazib beruvchilari (rasmiy distribyutorlar, dilerlar, ishlab
                                chiqaruvchilarning savdo vakillari va ularning distribyutorlari, litsenziatlari) bilan
                                tuzilgan to‘g‘ridan-to‘g‘ri shartnoma asosida import qiluvchilar reyestriga kirish uchun
                                arizaga ilova qilinadigan ma'lumot va hujjatlar ro‘yxati</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-6">
                                <label class="form-label" for="ecommerce-product-name">1. Ariza beruvchining nomi
                                    (yuridik shaxs — tashkilot nomi) *</label>
                                @if($errors->has('name'))
                                    <div class="alert alert-danger">
                                        {{$errors->first('name')}}
                                    </div>
                                @endif
                                <input type="text" class="form-control" id="ecommerce-product-name"
                                       placeholder="Name" name="name" aria-label="Name" value="{{$application->name}}">

                            </div>
                            <div class="mb-6">
                                <label class="form-label" for="ecommerce-product-name"> 2. Manzili/Joylashgan joyi
                                    (pochta manzili)</label>
                                @if($errors->has('address'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('address')}}
                                    </div>
                                @endif
                                <input type="text" class="form-control" id="ecommerce-product-name"
                                       placeholder="address" name="address" aria-label="Name"
                                       value="{{$application->address}}">
                            </div>
                            <div class="mb-6">
                                <label class="form-label" for="ecommerce-product-name"> 3. KTUT, STIR, IFUT kodi</label>
                                @if($errors->has('tin'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('tin')}}
                                    </div>
                                @endif
                                <input type="text" class="form-control" id="ecommerce-product-name"
                                       placeholder="tin" name="tin" aria-label="Name" value="{{$application->tin}}">
                            </div>
                            <div class="mb-6">
                                <label class="form-label" for="ecommerce-product-name"> 4. Telefon raqami</label>
                                @if($errors->has('phone'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('phone')}}
                                    </div>
                                @endif
                                <input type="text" class="form-control" id="ecommerce-product-name"
                                       placeholder="phone" name="phone" aria-label="Name"
                                       value="{{$application->phone}}">
                            </div>
                            <div class="mb-6">
                                <label class="form-label" for="ecommerce-product-name"> 5. Bank rekvizitlari</label>
                                @if($errors->has('bank_requisite'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('bank_requisite')}}
                                    </div>
                                @endif
                                <input type="text" class="form-control" id="ecommerce-product-name"
                                       placeholder="bank_requisite" name="bank_requisite" aria-label="Name"
                                       value="{{$application->bank_requisite}}">
                            </div>
                            <div class="mb-6">
                                <label class="form-label" for="ecommerce-product-name"> 6. Olib kelinayotgan brend
                                    nomi</label>
                                @if($errors->has('brand_name'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('brand_name')}}
                                    </div>
                                @endif
                                <input type="text" class="form-control" id="ecommerce-product-name"
                                       placeholder="brand_name" name="brand_name" aria-label="Name"
                                       value="{{$application->brand_name}}">
                            </div>
                            <div>
                                <label class="mb-1">7. Ariza berilayotgan tovarning TIF TN bo‘yicha tasnif kodi haqida
                                    ma'lumot</label>
                                @if($errors->has('mxik'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('mxik')}}
                                    </div>
                                @endif
                                <textarea class="form-control" aria-label="With textarea" placeholder="mxik"
                                          name="mxik">{{$application->mxik}}</textarea>
                            </div>
                        </div>
                    </div>
                    <!-- /Product Information -->
                    <!-- Media -->
                    <div class="card mb-6">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 card-title">8. Xalqaro brendlar tovarlari ayrim turlarining brend egalari
                                yoki ularning vakolatli yetkazib beruvchilari (rasmiy distribyutorlar, dilerlar, ishlab
                                chiqaruvchilarning savdo vakillari va ularning distrib'yutorlari, lisenziatlari)
                                ekanligini tasdiqlovchi rasmiy hujjatlar</h5>
                        </div>
                        <div class="card-body">
                            @if($errors->has('official_documents'))
                                <div class="alert alert-danger" role="alert">
                                    {{$errors->first('official_documents')}}
                                </div>
                            @endif
                            <label for="formFile" class="form-label">20mb dan ko'p bo'lmagan fayl biriktiring</label>
                            <input class="form-control" type="file" id="formFile" name="official_documents">
                            @if ($application->official_documents)
                                <dl class="row mt-4">
                                    <hr class="mb-2"/>
                                    <dt class="col-sm-3">avval yuklangan hujjat</dt>
                                    <dd class="col-sm-3"><a href="{{asset($application->official_documents)}}" download>
                                            yuklash <br><img
                                                src="{{asset('project-assets/logo/documents.png')}}" alt=""
                                                width="50px"> </a></dd>
                                </dl>
                            @endif
                        </div>

                    </div>
                    <div class="card mb-6">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 card-title">9. To‘g‘ridan-to‘g‘ri tuzilgan import shartnomalarining raqami
                                va sanasi</h5>
                        </div>
                        <div class="card-body">
                            @if($errors->has('contract_details'))
                                <div class="alert alert-danger" role="alert">
                                    {{$errors->first('contract_details')}}
                                </div>
                            @endif
                            <input type="text" class="form-control" id="ecommerce-product-name"
                                   placeholder="contract_details" name="contract_details" aria-label="Name"
                                   value="{{$application->contract_details}}">
                        </div>
                    </div>
                    <div class="card mb-6">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 card-title">10. Jahonning quyidagi mintaqalaridan kamida ikkitasi — Shimoliy
                                Amerika, Yevropa, Yaqin Sharq, Sharqiy Osiyoning chakana savdo tarmog‘ida brend
                                mahsulotlarining mavjudligini tasdiqlovchi hujjatlar</h5>
                        </div>
                        <div class="card-body">
                            @if($errors->has('at_least_country_documents'))
                                <div class="alert alert-danger" role="alert">
                                    {{$errors->first('at_least_country_documents')}}
                                </div>
                            @endif
                            <label for="formFile" class="form-label">20mb dan ko'p bo'lmagan fayl biriktiring</label>
                            <input class="form-control" type="file" id="formFile" name="at_least_country_documents">
                            @if ($application->at_least_country_documents)
                                <dl class="row mt-4">
                                    <hr class="mb-2"/>
                                    <dt class="col-sm-3">avval yuklangan hujjat</dt>
                                    <dd class="col-sm-3"><a href="{{asset($application->at_least_country_documents)}}"
                                                            download>
                                            yuklash <br><img
                                                src="{{asset('project-assets/logo/documents.png')}}" alt=""
                                                width="50px"> </a></dd>
                                </dl>
                            @endif
                        </div>
                    </div>
                    <div class="card mb-6">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 card-title">11. Tovarning kelib chiqishi mamlakati va ishlab chiqaruvchisi
                                haqida dastlabki ma'lumot (yuk bojxona hududiga kelib tushganda kelib chiqish
                                sertifikati, eksport deklaratsiyasi va tranzit deklaratsiyasi (mavjud bo‘lsa) bilan
                                tasdiqlanadi)</h5>
                        </div>
                        <div class="card-body">
                            @if($errors->has('manufactured_countries'))
                                <div class="alert alert-danger" role="alert">
                                    {{$errors->first('manufactured_countries')}}
                                </div>
                            @endif
                            <textarea class="form-control" aria-label="With textarea"
                                      placeholder="manufactured_countries"
                                      name="manufactured_countries">{{$application->manufactured_countries}}</textarea>
                        </div>
                    </div>

                    <div class="card mb-6">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 card-title">12. Chakana savdoni amalga oshirish uchun moddiy-texnika bazasi
                                mavjudligini tasdiqlovchi hujjatlar</h5>
                        </div>
                        <div class="card-body">
                            @if($errors->has('retail_documents'))
                                <div class="alert alert-danger" role="alert">
                                    {{$errors->first('retail_documents')}}
                                </div>
                            @endif
                            <label for="formFile" class="form-label">20mb dan ko'p bo'lmagan fayl biriktiring</label>
                            <input class="form-control" type="file" id="formFile" name="retail_documents">
                            @if ($application->retail_documents)
                                <dl class="row mt-4">
                                    <hr class="mb-2"/>
                                    <dt class="col-sm-3">avval yuklangan hujjat</dt>
                                    <dd class="col-sm-3"><a href="{{asset($application->retail_documents)}}" download>
                                            yuklash <br><img
                                                src="{{asset('project-assets/logo/documents.png')}}" alt=""
                                                width="50px"> </a></dd>
                                </dl>
                            @endif
                        </div>
                    </div>
                    <div class="card mb-6">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 card-title">13. Xalqaro brendlar import qiluvchining tovarlarini realizasiya
                                qilishi (savdo qilishi) uchun o‘zining yoki ijaraga olingan bino, inshoot ob'ekt(lar)i
                                mavjudligi haqida ma'lumot</h5>
                        </div>
                        <div class="card-body">
                            @if($errors->has('rent_building_documents'))
                                <div class="alert alert-danger" role="alert">
                                    {{$errors->first('rent_building_documents')}}
                                </div>
                            @endif
                            <label for="formFile" class="form-label">20mb dan ko'p bo'lmagan fayl biriktiring</label>
                            <input class="form-control" type="file" id="formFile" name="rent_building_documents">
                            @if ($application->rent_building_documents)
                                <dl class="row mt-4">
                                    <hr class="mb-2"/>
                                    <dt class="col-sm-3">avval yuklangan hujjat</dt>
                                    <dd class="col-sm-3"><a href="{{asset($application->rent_building_documents)}}"
                                                            download>
                                            yuklash <br><img
                                                src="{{asset('project-assets/logo/documents.png')}}" alt=""
                                                width="50px"> </a></dd>
                                </dl>
                            @endif
                        </div>
                    </div>
                    <div class="card mb-6">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 card-title">14. Xalqaro distribyutorlik tarmoqlari mavjudligi haqida
                                ma'lumot</h5>
                        </div>
                        <div class="card-body">
                            @if($errors->has('distributor_documents'))
                                <div class="alert alert-danger" role="alert">
                                    {{$errors->first('distributor_documents')}}
                                </div>
                            @endif
                            <label for="formFile" class="form-label">20mb dan ko'p bo'lmagan fayl biriktiring</label>
                            <input class="form-control" type="file" id="formFile" name="distributor_documents">
                            @if ($application->distributor_documents)
                                <dl class="row mt-4">
                                    <hr class="mb-2"/>
                                    <dt class="col-sm-3">avval yuklangan hujjat</dt>
                                    <dd class="col-sm-3"><a href="{{asset($application->distributor_documents)}}"
                                                            download>
                                            yuklash <br><img
                                                src="{{asset('project-assets/logo/documents.png')}}" alt=""
                                                width="50px"> </a></dd>
                                </dl>
                            @endif
                        </div>
                    </div>
                    <div class="card mb-6">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 card-title">15. Brendlar rasmiy internet saytlarining mavjudligi haqida
                                ma'lumot</h5>
                        </div>
                        <div class="card-body">
                            @if($errors->has('website_documents'))
                                <div class="alert alert-danger" role="alert">
                                    {{$errors->first('website_documents')}}
                                </div>
                            @endif
                            <label for="formFile" class="form-label">20mb dan ko'p bo'lmagan fayl biriktiring</label>
                            <input class="form-control" type="file" id="formFile" name="website_documents">
                            @if ($application->website_documents)
                                <dl class="row mt-4">
                                    <hr class="mb-2"/>
                                    <dt class="col-sm-3">avval yuklangan hujjat</dt>
                                    <dd class="col-sm-3"><a href="{{asset($application->website_documents)}}" download>
                                            yuklash <br><img
                                                src="{{asset('project-assets/logo/documents.png')}}" alt=""
                                                width="50px"> </a></dd>
                                </dl>
                            @endif
                        </div>
                    </div>
                    <!-- /Media -->

                </div>
                <!-- /Second column -->

            </div>

        </div>
    </form>

@endsection
