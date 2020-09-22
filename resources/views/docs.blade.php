@extends('layouts.master')

@section('title', 'Documentation')

@section('content')
    <p class="text-center home-tagline">The complete documentation of our JSON API</p>

    <div class="row">
        <div class="col-md-3 visible-md-block visible-lg-block">
            <div id="docs-nav">
                <div class="list-group">
                    @foreach ($sections as $id => $name)
                        <a href="#{{ $id }}" class="list-group-item">{{ $name }}</a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-9">
            @foreach ($sections as $id => $name)
                <article id="{{ $id }}">
                    <h3>{{ $name }}</h3>

                    @include('docs.' . $id)
                </article>
            @endforeach
        </div>
    </div>
@stop

@section('script')
    <script>
        $(function () {
            let $nav = $('#docs-nav');
            let offsetTop = $nav.offset().top;
            let startSticky = (offsetTop - 20);

            $(document).on('scroll', function () {
                let top = $(document).scrollTop();

                if (top > startSticky) {
                    $nav.css({
                        position: 'fixed',
                        top: '20px',
                        width: $nav.parent().width(),
                    });
                } else {
                    $nav.css({
                        position: 'relative',
                    });
                }
            });

            $('.list-group-item').on('click', function () {
                $('.list-group-item.active').removeClass('active');
                $(this).addClass('active');
            });

            let $accordionLinks = $('#accordion .panel-heading a');

            $accordionLinks.append(
                $('<i>').addClass('fa fa-arrow-down pull-right'),
            );

            $accordionLinks.on('click', function () {
                $(this).find('i').toggleClass('fa-arrow-down').toggleClass('fa-arrow-up');
            });
        });
    </script>
@stop
