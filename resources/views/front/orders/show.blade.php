<x-front-layout title="Order Details">

    <x-slot:breadcrumb>
        <!-- Start Breadcrumbs -->
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Order #{{ $order->id }}</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                            <li><a href="#">Orders</a></li>
                            <li>Order #{{ $order->id }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcrumbs -->
    </x-slot:breadcrumb>

    <!--====== Checkout Form Steps Part Start ======-->

    <section class="checkout-wrapper section">
        <div class="container">
            <div id="map" style="height: 50vh;">

            </div>
        </div>
    </section>

    <script>
        // Initialize and add the map
        let map;

        async function initMap() {
            // The location of Order
            const position = {
                lat: {{ $delivery->latitude }},
                lng: {{ $delivery->longitude }}
            };
            // Request needed libraries.
            //@ts-ignore
            const {
                Map
            } = await google.maps.importLibrary("maps");
            const {
                AdvancedMarkerElement
            } = await google.maps.importLibrary("marker");

            // The map, centered at Order
            map = new Map(document.getElementById("map"), {
                zoom: 14,
                center: position,
                mapId: "DEMO_MAP_ID",
            });

            // The marker, positioned at Order
            const marker = new AdvancedMarkerElement({
                map: map,
                position: position,
                title: "Order",
            });
        }

        initMap();
    </script>

    <script
        src="https://maps.googleapis.com/maps/api/js?libraries=places&key={{ config('services.google.api_key') }}&callback=initMap"
        async defer loading="async"></script>

</x-front-layout>
