@if ($page == '')
@include('livewire.registration.home-services.home-services')
@elseif ($page == 'registrationDetails')
@include('livewire.registration.home-services.home-registrationDetails')
@elseif ($page == 'servicesDetails')
@include('livewire.registration.home-services.home-servicesDetails')
@elseif ($page == 'newRegistration')
@include('livewire.registration.home-services.home-newRegistration')
@elseif ($page == 'AppReviews')
@include('livewire.registration.home-services.app-reviews')
@endif
