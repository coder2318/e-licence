@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Login Basic - Pages')

@section('vendor-style')
    @vite([
      'resources/assets/vendor/libs/@form-validation/form-validation.scss'
    ])
@endsection

@section('page-style')
    @vite([
      'resources/assets/vendor/scss/pages/page-auth.scss'
    ])
@endsection

@section('vendor-script')
    @vite([
      'resources/assets/vendor/libs/@form-validation/popular.js',
      'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
      'resources/assets/vendor/libs/@form-validation/auto-focus.js'
    ])
@endsection

@section('page-script')
    @vite([
      'resources/assets/js/pages-auth.js'
    ])

    <script src="{{asset('project-assets/e-imzo/e-imzo.js')}}"></script>
    <script src="{{asset('project-assets/e-imzo/e-imzo-client.js')}}"></script>
    <script src="{{asset('project-assets/e-imzo/e-imzo-init.js')}}"></script>
    <script src="{{asset('project-assets/e-imzo/micro-ajax.js')}}"></script>

    <script>
        var uiLoading = function () {
            var l = document.getElementById('message');
            l.innerHTML = 'Загрузка ...';
            l.style.color = 'red';
        }

        var uiNotLoaded = function (e) {
            var l = document.getElementById('message');
            l.innerHTML = '';
            if (e) {
                wsError(e);
            } else {
                uiShowMessage(errorBrowserWS);
            }
        }

        var uiUpdateApp = function () {
            var l = document.getElementById('message');
            l.innerHTML = errorUpdateApp;
        }

        var uiAppLoad = function () {
            uiClearCombo();
            EIMZOClient.listAllUserKeys(function (o, i) {
                var itemId = "itm-" + o.serialNumber + "-" + i;
                return itemId;
            }, function (itemId, v) {
                return uiCreateItem(itemId, v);
            }, function (items, firstId) {
                uiFillCombo(items);
                uiLoaded();
                uiComboSelect(firstId);
            }, function (e, r) {
                if (e) {
                    uiShowMessage(errorCAPIWS + " : " + e);
                } else {
                    console.log(r);
                }
            });
            EIMZOClient.idCardIsPLuggedIn(function (yes) {
                document.getElementById('plugged').innerHTML = yes ? 'подключена' : 'не подключена';
            }, function (e, r) {
                if (e) {
                    uiShowMessage(errorCAPIWS + " : " + e);
                } else {
                    console.log(r);
                }
            })
        }

        var uiComboSelect = function (itm) {
            if (itm) {
                var id = document.getElementById(itm);
                id.setAttribute('selected', 'true');
            }
        }

        var cbChanged = function (c) {
            // var element = document.getElementById('keyId');
            // if (element) {
            //     element.innerHTML = '';
            // } else {
            //     console.error('Element with id "keyId" not found');
            // }
        }

        var uiClearCombo = function () {
            var combo = document.testform.key;
            combo.length = 0;
        }

        var uiFillCombo = function (items) {
            var combo = document.testform.key;
            for (var itm in items) {
                combo.append(items[itm]);
            }
        }

        var uiLoaded = function () {
            var l = document.getElementById('message');
            l.innerHTML = '';
        }

        var uiCreateItem = function (itmkey, vo) {
            var now = new Date();
            vo.expired = dates.compare(now, vo.validTo) > 0;
            var itm = document.createElement("option");
            itm.value = itmkey;
            // console.log('start');
            // console.log(vo);
            itm.text = vo.CN + ' - ' + vo.PINFL;
            if (!vo.expired) {

            } else {
                itm.style.color = 'gray';
                itm.text = itm.text + ' (срок истек)';
            }
            itm.setAttribute('vo', JSON.stringify(vo));
            itm.setAttribute('id', itmkey);
            return itm;
        }

        var keyType_changed = function () {
            var keyType = document.testform.keyType.value;
            document.getElementById('signButton').innerHTML = keyType === "pfx" ? "Kirish" : "Вход ключем ID-card";
        };

        keyType_changed();

        var uiShowProgress = function () {
            var l = document.getElementById('progress');
            l.innerHTML = 'Идет подписание, ждите.';
            l.style.color = 'green';
        };

        var uiHideProgress = function () {
            var l = document.getElementById('progress');
            l.innerHTML = '';
        };

        signin = function () {
            uiShowProgress();

            getChallenge(function (challenge) {
                var keyType = document.testform.keyType.value;
                if (keyType === "idcard") {
                    var keyId = "idcard";

                    auth(keyId, challenge, function (redirect) {
                        window.location.href = redirect;
                        uiShowProgress();
                    });

                } else {
                    var itm = document.testform.key.value;
                    if (itm) {
                        var id = document.getElementById(itm);
                        var vo = JSON.parse(id.getAttribute('vo'));

                        EIMZOClient.loadKey(vo, function (id) {
                            var keyId = id;

                            auth(keyId, challenge, function (redirect) {
                                window.location.href = redirect;
                                uiShowProgress();
                            });

                        }, uiHandleError);
                    } else {
                        uiHideProgress();
                    }
                }
            });
        };

        getChallenge = function (callback) {
            microAjax('/auth/e-imzo/challenge', function (data, s) {
                if (s.status != 200) {
                    uiShowMessage(s.status + " - " + s.statusText);
                    return;
                }
                try {
                    var data = JSON.parse(data);
                    if (data.error) {
                        uiShowMessage(data.error);
                        return;
                    }
                    callback(data.challenge);
                } catch (e) {
                    uiShowMessage(s.status + " - " + s.statusText + ": " + e);
                }
            });
        }

        auth = function (keyId, challenge, callback) {
            EIMZOClient.createPkcs7(keyId, challenge, null, function (pkcs7) {
                microAjax('/auth/e-imzo/auth', function (data, s) {
                    uiHideProgress();
                    if (s.status != 200) {
                        uiShowMessage('test' + s.status + " - " + s.statusText);
                        return;
                    }
                    try {
                        var data = JSON.parse(data);
                        if (data.status != 1) {
                            uiShowMessage('test1' + data.status + " - " + data.message);
                            return;
                        }
                        callback(data.redirect);
                    } catch (e) {
                        uiShowMessage('test2' + s.status + " - " + s.statusText + ": " + e);
                    }

                }, 'keyId=' + encodeURIComponent(keyId) + '&pkcs7=' + encodeURIComponent(pkcs7));
            }, uiHandleError, false);
        }

        document.addEventListener("DOMContentLoaded", function () {
            // Найти все элементы с классом eimzo-open
            var buttons = document.querySelectorAll('.eimzo-open');

            // Добавить обработчик события click для каждого из них
            buttons.forEach(function (button) {
                button.addEventListener('click', function (event) {
                    AppLoad(); // Вызов вашей функции
                });
            });
        });

    </script>
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-6">
                <!-- Login -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-6">
                            <a href="{{url('/')}}" class="app-brand-link">
                                <span
                                    class="app-brand-logo demo">@include('_partials.macros',['height'=>20,'withbg' => "fill: #fff;"])</span>
                                <span
                                    class="app-brand-text demo text-heading fw-bold">{{ config('variables.templateName') }}</span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1">Welcome to E-licence 👋</h4>
                        <p class="mb-6">Akkountga kiring</p>

                        <div class="mb-6">
                            <a href="{{route('one-id.redirect')}}" class="btn btn-primary d-grid w-100" type="submit">OneID</a>
                        </div>
                        <div class="m-6">
                            <a href="https://e-imzo.uz"
                               class="btn btn-icon btn-label-primary custom-btn eimzo-open"
                               data-bs-toggle="modal" data-bs-target="#twoFactorAuth">
                                <img src="{{ asset('project-assets/logo/e_imzo.png') }}" alt="E-imzo"
                                     class="img-fluid custom-img">
                            </a>
                            <p class="text-center mt-1">E-imzo orqali kirish</p>
                        </div>
                        <form name="testform">
                            <div class="text-center mb-4">
                                <h3 class="mb-2">E-imzo orqali kirish</h3>
                                <p class="text-muted">Kirish uchun kalit tanlang</p>
                            </div>

                            <label id="message" style="color: red;"></label>

                            <input type="radio" id="pfx" hidden="hidden" name="keyType" value="pfx"
                                   onchange="keyType_changed()"
                                   checked="checked">
                            <select name="key" class="select2 form-select form-select-lg" onchange="cbChanged(this)"></select><br>
                            <br>
                            <button onclick="signin()" type="button" id="signButton" class="btn btn-outline-success">
                                Kirish
                            </button>
                            <br>
                            <label id="progress" style="color: green;"></label>
                        </form>

                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>
@endsection
