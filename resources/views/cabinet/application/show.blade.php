@extends('layouts/layoutMaster')

@section('title', 'Typography - UI elements')

@section('content')

    @if($application->isNew())
        <div class="d-flex align-content-center flex-wrap gap-4 mb-2">
            <a href="{{route('application.edit', ['application' => $application->id])}}" class="btn btn-primary"><span
                    class="ti-xs ti ti-pencil me-2"></span>Edit application</a>
        </div>
    @endif
    <div class="row">
        <!-- Blockquote -->
        <div class="col-lg">
            <div class="card mb-6 mb-lg-0">
                <h5 class="card-header">Ma'lumotlar</h5>
                <hr class="m-0"/>
                <div class="card-body">
                    <small class="text-light fw-medium">Ariza ID</small>
                    <figure class="mt-2">
                        <blockquote class="blockquote">
                            <p class="mb-0">{{$application->id}}</p>
                        </blockquote>
                    </figure>
                    <small class="text-light fw-medium">Ariza beruvchining nomi (yuridik shaxs — tashkilot nomi)
                        *</small>
                    <figure class="mt-2">
                        <blockquote class="blockquote">
                            <p class="mb-0">{{$application->name}}</p>
                        </blockquote>
                    </figure>
                    <small class="text-light fw-medium"> Manzili/Joylashgan joyi (pochta manzili)</small>
                    <figure class="mt-2">
                        <blockquote class="blockquote">
                            <p class="mb-0">{{$application->address}}</p>
                        </blockquote>
                    </figure>
                    <small class="text-light fw-medium">KTUT, STIR, IFUT kodi</small>
                    <figure class="mt-2">
                        <blockquote class="blockquote">
                            <p class="mb-0">{{$application->tin}}</p>
                        </blockquote>
                    </figure>
                    <small class="text-light fw-medium">Telefon raqami</small>
                    <figure class="mt-2">
                        <blockquote class="blockquote">
                            <p class="mb-0">{{$application->phone}}</p>
                        </blockquote>
                    </figure>
                    <small class="text-light fw-medium">Bank rekvizitlari</small>
                    <figure class="mt-2">
                        <blockquote class="blockquote">
                            <p class="mb-0">{{$application->bank_requisite}}</p>
                        </blockquote>
                    </figure>
                    <small class="text-light fw-medium">Olib kelinayotgan brend nomi</small>
                    <figure class="mt-2">
                        <blockquote class="blockquote">
                            <p class="mb-0">{{$application->brand_name}}</p>
                        </blockquote>
                    </figure>
                    <small class="text-light fw-medium">Ariza berilayotgan tovarning TIF TN bo‘yicha tasnif kodi haqida
                        ma'lumot</small>
                    <figure class="mt-2">
                        <blockquote class="blockquote">
                            <p class="mb-0">{{$application->mxik}}</p>
                        </blockquote>
                    </figure>
                    <small class="text-light fw-medium"> To‘g‘ridan-to‘g‘ri tuzilgan import shartnomalarining raqami va
                        sanasi</small>
                    <figure class="mt-2">
                        <blockquote class="blockquote">
                            <p class="mb-0">{{$application->contract_details}}</p>
                        </blockquote>
                    </figure>
                    <small class="text-light fw-medium">Tovarning kelib chiqishi mamlakati va ishlab chiqaruvchisi
                        haqida dastlabki ma'lumot (yuk bojxona hududiga kelib tushganda kelib chiqish sertifikati,
                        eksport deklaratsiyasi va tranzit deklaratsiyasi (mavjud bo‘lsa) bilan tasdiqlanadi)</small>
                    <figure class="mt-2">
                        <blockquote class="blockquote">
                            <p class="mb-0">{{$application->manufactured_countries}}</p>
                        </blockquote>
                    </figure>
                    <small class="text-light fw-medium">Expert Comment</small>
                    <figure class="mt-2">
                        <blockquote class="blockquote">
                            <p class="mb-0">{{$application->reason_rejected??'-'}}</p>
                        </blockquote>
                    </figure>
                </div>
            </div>
        </div>
        <div class="col-lg">
            <div class="card">
                <h5 class="card-header">Fayllar</h5>
                <hr class="m-0"/>
                <div class="card-body">
                    <dl class="row mt-2">
                        <dt class="col-sm-9">Xalqaro brendlar tovarlari ayrim turlarining brend egalari yoki ularning
                            vakolatli yetkazib beruvchilari (rasmiy distribyutorlar, dilerlar, ishlab chiqaruvchilarning
                            savdo vakillari va ularning distrib'yutorlari, lisenziatlari) ekanligini tasdiqlovchi rasmiy
                            hujjatlar
                        </dt>
                        <dd class="col-sm-3"><a href="{{asset($application->official_documents)}}" download> yuklash
                                <br><img
                                    src="{{asset('project-assets/logo/documents.png')}}" alt="" width="50px"> </a></dd>
                        <span class="mb-4"></span>

                        <dt class="col-sm-9">Jahonning quyidagi mintaqalaridan kamida ikkitasi — Shimoliy Amerika,
                            Yevropa, Yaqin Sharq, Sharqiy Osiyoning chakana savdo tarmog‘ida brend mahsulotlarining
                            mavjudligini tasdiqlovchi hujjatlar
                        </dt>
                        <dd class="col-sm-3"><a href="{{asset($application->at_least_country_documents)}}" download>
                                yuklash <br><img
                                    src="{{asset('project-assets/logo/documents.png')}}" alt="" width="50px"> </a></dd>
                        <span class="mb-4"></span>

                        <dt class="col-sm-9">Chakana savdoni amalga oshirish uchun moddiy-texnika bazasi mavjudligini
                            tasdiqlovchi hujjatlar
                        </dt>
                        <dd class="col-sm-3"><a href="{{asset($application->retail_documents)}}" download> yuklash
                                <br><img
                                    src="{{asset('project-assets/logo/documents.png')}}" alt="" width="50px"> </a></dd>
                        <span class="mb-4"></span>

                        <dt class="col-sm-9">Xalqaro brendlar import qiluvchining tovarlarini realizasiya qilishi (savdo
                            qilishi) uchun o‘zining yoki ijaraga olingan bino, inshoot ob'ekt(lar)i mavjudligi haqida
                            ma'lumot
                        </dt>
                        <dd class="col-sm-3"><a href="{{asset($application->rent_building_documents)}}" download>
                                yuklash <br><img
                                    src="{{asset('project-assets/logo/documents.png')}}" alt="" width="50px"> </a></dd>
                        <span class="mb-4"></span>

                        <dt class="col-sm-9">Xalqaro distribyutorlik tarmoqlari mavjudligi haqida ma'lumot</dt>
                        <dd class="col-sm-3"><a href="{{asset($application->distributor_documents)}}" download> yuklash
                                <br><img
                                    src="{{asset('project-assets/logo/documents.png')}}" alt="" width="50px"> </a></dd>
                        <span class="mb-4"></span>

                        <dt class="col-sm-9">Brendlar rasmiy internet saytlarining mavjudligi haqida ma'lumot</dt>
                        <dd class="col-sm-3"><a href="{{asset($application->website_documents)}}" download> yuklash <br><img
                                    src="{{asset('project-assets/logo/documents.png')}}" alt="" width="50px"> </a></dd>
                        <span class="mb-4"></span>
                    </dl>
                </div>
            </div>
        </div>


    </div>

    <div class="row">
        <!-- Timeline Basic-->
        <div class="col-lg-6 mb-6 mt-6">
            <div class="card">
                <h5 class="card-header">Status</h5>
                <div class="card-body">
                    <ul class="timeline mb-0">
                        @if($application->history)
                            @foreach($application->history as $history)
                                <li class="timeline-item timeline-item-transparent">
                                    <span
                                        class="timeline-point timeline-point-{{$history->new_status % 2 == 0 ? 'primary' : 'success'}}"></span>
                                    <div class="timeline-event">
                                        <div class="timeline-header mb-3">
                                            <h6 class="mb-0">{{__('translate.application.'.$history->old_status_text)}}
                                                -> {{__('translate.application.'.$history->new_status_text)}}</h6>
                                            <small class="text-muted">{{$history->created_at}}</small>
                                        </div>
                                        <p class="mb-2">
                                            Application Status changed
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Timeline Basic -->
    </div>
    @if($application->isNew())
        <div class="d-flex flex-wrap gap-4 mt-2">
            <form action="{{ route('application.destroy', ['application' => $application->id]) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <span class="ti-xs ti ti-trash me-2"></span>
                    Delete
                </button>
            </form>
        </div>
    @endif

@endsection
