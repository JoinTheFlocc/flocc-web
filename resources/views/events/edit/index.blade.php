@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="margin:80px 0;">
            <h1>Edytuj wydarzenie</h1>

            <div class="flocc-tabs">
                <div class="flocc-tab" tab-id="default">
                    1<br><br>

                    <a href="#" class="btn btn-primary tab-action change-tab" action-tab-id="something">Dalej</a>
                </div>
                <div class="flocc-tab" tab-id="something">
                    2<br><br>

                    <a href="#" class="btn btn-default tab-action change-tab" action-tab-id="default">Wstecz</a>
                    <a href="#" class="btn btn-primary tab-action change-tab" action-tab-id="last-one">Dalej</a>
                </div>
                <div class="flocc-tab" tab-id="last-one">
                    3<br><br>

                    <a href="#" class="tab-action change-tab" action-tab-id="something">Wstecz</a>
                </div>
            </div>
        </div>
    </div>

    <script src="/js/theme/tabs.js"></script>
    <script>
        $(function() {
            FloccTabs.Init('default');
        });
    </script>
@endsection
