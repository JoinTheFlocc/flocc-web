@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="margin: 100px 0; text-align: center;">
            <div class="col-sm-12">
                <div class="alert alert-success" style="font-size:20px;">
                    <i class="fa fa-check"></i> Wydarzenie zostało utworzone!
                </div>

                <a href="#" class="btn btn-primary facebook_share" facebook-url="{{ $meta_facebook->getUrl() }}" facebook-title="{{ $meta_facebook->getTitle() }}" facebook-img="{{ $meta_facebook->getImage() }}" facebook-desc="{{ $meta_facebook->getDescription() }}">
                    <i class="fa fa-facebook-official"></i> Udostępnij na Facebooku
                </a>
                <a href="{{ URL::route('events.event', ['id' => $event->getId(), 'slug' => $event->getSlug()]) }}" class="btn btn-success">
                    <i class="fa fa-arrow-right"></i> Przejdź do wydarzenia
                </a>
            </div>
        </div>
    </div>
@endsection
