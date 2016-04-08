@extends('layouts.app')
@section('content')
    <section id="main">
        <div class="container mainBoxA">
            <div class="contentBox">
                <div class="row">
                    <div class="col-md-3">
                        <div class="well">
                            <img src="{{ $profile->avatar_url }}" class="img-thumbnail">
                            <h4 style="color: royalblue;">{{ $profile->firstname . " " . $profile->lastname }}</h4>
                            <p><i class="fa fa-map-marker"></i> Poland</p>
                            <p>{{ $profile->description }}</p>
                            <br>
                            @if(!$is_mine)
                                <a href="{{ URL::route('mail.new.form', ['user_id' => $profile->user_id]) }}" class="btn btn-success btn-block">
                                    <i class="fa fa-envelope"></i> Start chat
                                </a>
                            @else
                                <a href="{{ URL::route('profile.edit', ['id' => $profile->id]) }}" class="btn btn-success btn-block">
                                    <i class="fa fa-edit"></i> Edit profile
                                </a>
                            @endif
                        </div>

                        <!-- Tags Well -->
                        <div class="well">
                            <h4>Dane o użytkowniku</h4>

                            <ul>
                                @if($profile->getPartying() !== null)
                                    <li>
                                        Imprezowanie: {{ $profile->getPartying()->getName() }}
                                    </li>
                                @endif
                                @if($profile->getAlcohol() !== null)
                                    <li>
                                        Alkohol: {{ $profile->getAlcohol()->getName() }}
                                    </li>
                                @endif
                                @if($profile->getSmoking() !== null)
                                    <li>
                                        Palenie: {{ $profile->getSmoking()->getName() }}
                                    </li>
                                @endif
                                @if($profile->getImprecation() !== null)
                                    <li>
                                        Czy przeszkadza Ci przeklinanie: {{ $profile->getImprecation()->getName() }}
                                    </li>
                                @endif
                                @if($profile->getPlannings() !== null)
                                    <li>
                                        Planowanie: {{ $profile->getPlannings()->getName() }}
                                    </li>
                                @endif
                                @if($profile->getPlans() !== null)
                                    <li>
                                        Zmiana planów: {{ $profile->getPlans()->getName() }}
                                    </li>
                                @endif
                                @if($profile->getVegetarian() !== null)
                                    <li>
                                        Wegetarianizm: {{ $profile->getVegetarian()->getName() }}
                                    </li>
                                @endif
                                @if($profile->getVerbosity() !== null)
                                    <li>
                                        Gadatliwość: {{ $profile->getVerbosity()->getName() }}
                                    </li>
                                @endif
                                @if($profile->getVigor() !== null)
                                    <li>
                                        Energiczność: {{ $profile->getVigor()->getName() }}
                                    </li>
                                @endif
                                @if($profile->getCool() !== null)
                                    <li>
                                        Wyluzowanie: {{ $profile->getCool()->getName() }}
                                    </li>
                                @endif
                                @if($profile->getRules() !== null)
                                    <li>
                                        Reguły: {{ $profile->getRules()->getName() }}
                                    </li>
                                @endif
                                @if($profile->getOpinions() !== null)
                                    <li>
                                        Poglądy: {{ $profile->getOpinions()->getName() }}
                                    </li>
                                @endif
                                @if($profile->getTolerance() !== null)
                                    <li>
                                        Tolerancja: {{ $profile->getTolerance()->getName() }}
                                    </li>
                                @endif
                                @if($profile->getCompromise() !== null)
                                    <li>
                                        Kompromisy: {{ $profile->getCompromise()->getName() }}
                                    </li>
                                @endif
                                @if($profile->getFeelings() !== null)
                                    <li>
                                        Uczucia: {{ $profile->getFeelings()->getName() }}
                                    </li>
                                @endif
                                @if($profile->getEmergency() !== null)
                                    <li>
                                        Sytuacje awaryjne: {{ $profile->getEmergency()->getName() }}
                                    </li>
                                @endif
                            </ul>

                            <h4>Cechy użytkownika</h4>
                            <ul>
                                @foreach($profile->getFeatures() as $feature)
                                    <li>
                                        {{ $feature->getName() }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- Dashboard content -->
                    <div class="col-md-9">
                        TIME LINE
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection