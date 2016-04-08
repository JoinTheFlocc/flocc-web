@extends('layouts.app')

@section('content')
    <div class="container">
        <br>
        <div class="contentBox">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Edit profile > Ustawienia</h4>
                </div>
                <div class="panel-body">
                    <!-- Display flash messages -->
                    @include('common.errors')
                    @if (isset($message))
                        <div class="flash-message">
                            <p class="alert alert-success">{{ $message }}</p>
                        </div>
                    @endif

                    <form method="post">
                        <!-- partying_id -->
                        <div class="form-group">
                            <label class="control-label">Imprezowanie</label>
                            <div>
                                @foreach($partying as $row)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="partying_id" value="{{ $row->getId() }}" @if($row->getId() == $profile->getPartyingId()) checked="checked" @endif> {{ $row->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- alcohol_id -->
                        <div class="form-group">
                            <label class="control-label">Alkohol</label>
                            <div>
                                @foreach($alcohol as $row)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="alcohol_id" value="{{ $row->getId() }}" @if($row->getId() == $profile->getAlcoholId()) checked="checked" @endif> {{ $row->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- smoking_id -->
                        <div class="form-group">
                            <label class="control-label">Palenie</label>
                            <div>
                                @foreach($smoking as $row)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="smoking_id" value="{{ $row->getId() }}" @if($row->getId() == $profile->getSmokingId()) checked="checked" @endif> {{ $row->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- imprecation_id -->
                        <div class="form-group">
                            <label class="control-label">Czy przeszkadza Ci przeklinanie</label>
                            <div>
                                @foreach($imprecation as $row)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="imprecation_id" value="{{ $row->getId() }}" @if($row->getId() == $profile->getImprecationId()) checked="checked" @endif> {{ $row->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- plannings_id -->
                        <div class="form-group">
                            <label class="control-label">Planowanie</label>
                            <div>
                                @foreach($plannings as $row)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="plannings_id" value="{{ $row->getId() }}" @if($row->getId() == $profile->getPlanningsId()) checked="checked" @endif> {{ $row->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- plans_id -->
                        <div class="form-group">
                            <label class="control-label">Zmiana planów</label>
                            <div>
                                @foreach($plans as $row)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="plans_id" value="{{ $row->getId() }}" @if($row->getId() == $profile->getPlansId()) checked="checked" @endif> {{ $row->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- vegetarian_id -->
                        <div class="form-group">
                            <label class="control-label">Wegetarianin</label>
                            <div>
                                @foreach($vegetarian as $row)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="vegetarian_id" value="{{ $row->getId() }}" @if($row->getId() == $profile->getVegetarianId()) checked="checked" @endif> {{ $row->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- flexibility_id
                        <div class="form-group">
                            <label class="control-label">Elastyczność</label>
                            <div>
                                @foreach($flexibility as $row)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="flexibility_id" value="{{ $row->getId() }}" @if($row->getId() == $profile->getFlexibilityId()) checked="checked" @endif> {{ $row->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- plans_change_id
                        <div class="form-group">
                            <label class="control-label">Zmiana planów</label>
                            <div>
                                @foreach($plans_change as $row)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="plans_change_id" value="{{ $row->getId() }}" @if($row->getId() == $profile->getPlansChangeId()) checked="checked" @endif> {{ $row->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>-->

                        <!-- verbosity_id -->
                        <div class="form-group">
                            <label class="control-label">Gadatliwość</label>
                            <div>
                                @foreach($verbosity as $row)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="verbosity_id" value="{{ $row->getId() }}" @if($row->getId() == $profile->getVerbosityId()) checked="checked" @endif> {{ $row->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- vigor_id -->
                        <div class="form-group">
                            <label class="control-label">Energiczność</label>
                            <div>
                                @foreach($vigor as $row)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="vigor_id" value="{{ $row->getId() }}" @if($row->getId() == $profile->getVigorId()) checked="checked" @endif> {{ $row->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- cool_id -->
                        <div class="form-group">
                            <label class="control-label">Wyluzowanie</label>
                            <div>
                                @foreach($cool as $row)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="cool_id" value="{{ $row->getId() }}" @if($row->getId() == $profile->getCoolId()) checked="checked" @endif> {{ $row->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- rules_id -->
                        <div class="form-group">
                            <label class="control-label">Jak bardzo pilnujesz dotrzymywania ustaleć z grupą (np. wczesna pobudka, załatwienie czegoś w ramach podziału obowiązków itp.)?</label>
                            <div>
                                @foreach($rules as $row)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="rules_id" value="{{ $row->getId() }}" @if($row->getId() == $profile->getRulesId()) checked="checked" @endif> {{ $row->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- opinions_id -->
                        <div class="form-group">
                            <label class="control-label">Jakie masz podejście do swoich poglądów np. religijnych, politycznych, dotyczących stylu życia?</label>
                            <div>
                                @foreach($opinions as $row)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="opinions_id" value="{{ $row->getId() }}" @if($row->getId() == $profile->getOpinionsId()) checked="checked" @endif> {{ $row->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- tolerance_id -->
                        <div class="form-group">
                            <label class="control-label">Jak często przeszkadza ci to, że ktoś myśli lub zachowuje się inaczej niż Ty?</label>
                            <div>
                                @foreach($tolerance as $row)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="tolerance_id" value="{{ $row->getId() }}" @if($row->getId() == $profile->getToleranceId()) checked="checked" @endif> {{ $row->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- compromise_id -->
                        <div class="form-group">
                            <label class="control-label">Jakie masz podejście do kompromisów</label>
                            <div>
                                @foreach($compromise as $row)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="compromise_id" value="{{ $row->getId() }}" @if($row->getId() == $profile->getCompromiseId()) checked="checked" @endif> {{ $row->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- feelings_id -->
                        <div class="form-group">
                            <label class="control-label">Jak ważne są dla Ciebie potrzeby i odczucia innych osób</label>
                            <div>
                                @foreach($feelings as $row)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="feelings_id" value="{{ $row->getId() }}" @if($row->getId() == $profile->getFeelingsId()) checked="checked" @endif> {{ $row->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- emergency_id -->
                        <div class="form-group">
                            <label class="control-label">W sytuacjach awaryjnych</label>
                            <div>
                                @foreach($emergency as $row)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="emergency_id" value="{{ $row->getId() }}" @if($row->getId() == $profile->getEmergencyId()) checked="checked" @endif> {{ $row->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- $features_sets -->
                        <div class="form-group">
                            <label class="control-label">Wybierz zestaw cech które do ciebie pasują</label>
                            <div>
                                @foreach($features_sets as $row)
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="features[]" value="{{ $row->getId() }}" @if(in_array($row->getId(), $profile->getFeaturesIds())) checked="checked" @endif> {{ $row->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- $features -->
                        <div class="form-group">
                            <label class="control-label">Inne cechy, które mnie opisują</label>
                            <div>
                                @foreach($features as $row)
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="features[]" value="{{ $row->getId() }}" @if(in_array($row->getId(), $profile->getFeaturesIds())) checked="checked" @endif> {{ $row->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- free time -->
                        <div class="form-group">
                            <label class="control-label">Dzień poza pracą</label>
                            <div>
                                @foreach($free_time as $row)
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="free_time[]" value="{{ $row->getId() }}" @if(in_array($row->getId(), $profile->getFreeTimeIds())) checked="checked" @endif> {{ $row->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <br>
                        <div>
                            <div class="form-group">
                                <label class="control-label">&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-success btn-lg">Zapisz</button>
                                </div>
                            </div>
                        </div>

                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
