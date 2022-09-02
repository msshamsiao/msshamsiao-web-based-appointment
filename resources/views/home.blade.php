@extends('layouts.admin')
@section('content')

<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<style type="text/css">
    #map {
        height: 400px;
    }
</style>

<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="container mt-5">
                <h2>Public Attorney Office San Jose Occidental Mindoro, Auria Arins Building 2nd flr., Brgy. 8 San Jose.</h2>
                <div id="map"></div>
            </div>
          
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @parent
    <script type="text/javascript">
        function initMap() {
          const myLatLng = { lat: 13.102411, lng: 120.765128 };
          const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 5,
            center: myLatLng,
          });
  
          new google.maps.Marker({
            position: myLatLng,
            map,
            title: "",
          });
        }
  
        window.initMap = initMap;
    </script>
  
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap" ></script>

@endsection