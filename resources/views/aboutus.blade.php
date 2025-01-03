@extends('layouts.app')
@section('title', 'About Us - Smugglers')
@section('content')
<style type="text/css">
  .aboutp p{
    font-size: 15px;
  }
</style>
      <link href="{{ asset('assets/css/hiw.min.css') }}" rel="stylesheet" type="text/css"/>
<div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <div class="breadcrumb_box">
                        <h2 class="breadcrumb-title">{{ $about->heading_one ?? '' }}</h2>
                        <!-- breadcrumb-list start -->
                        {!! $about->text_one ?? '' !!}
                        <!-- breadcrumb-list end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="main-wrapper">
        <div class="site-wrapper-reveal">
            <div class="bg-white">

            <div class="section-space--pt_30 ">
                  <div class="container">
                    <div class="row">
                      <div class="col-lg-6 ">
                                                <div class="tab-history-image">
                                                        <div class="">
                                                            <img class="img-fluid" src="{{ url($about->image_one) }}" style=" border: 2px solid #dbe4ed;    border-radius: 4px;">
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 d-flex align-items-center aboutp">
                                                <div class="tab-content-inner">
<div class="col-lg-12" style="">
<h6 class="section-title mb-20 mt-20">{{ $about->heading_two ?? '' }}</h6>
<div class="text mb-30">
 {!! $about->text_two ?? '' !!}
</div>
                                                </div>
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                  </div>                 
                  </div> 

                  <div class="section-space--ptb_30 ">
                  <div class="container">
                    <div class="row">
                                            <div class="col-lg-6 d-flex align-items-center aboutp">
                                                <div class="tab-content-inner">
<div class="col-lg-12" style="">
<h6 class="section-title mb-20">{{ $about->heading_three ?? '' }}</h6>
<div class="text mb-30">
{!! $about->text_three ?? '' !!}
</div>
                                                </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 ">
                                                <div class="tab-history-image">
                                                        <div class="">
                                                            <img class="img-fluid" src="{{ url($about->image_two) }}" style=" border: 2px solid #dbe4ed;    border-radius: 4px;">
                                                        </div>
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                  </div>                 
                  </div>                 


                 <!--====================  testimonial section ====================-->
            <div class="testimonial-slider-area section-space--ptb_60 bg-gray-3" style="display: ">
                <div class="container-fluid container-fluid--cp-80">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title-wrap text-center section-space--mb_60">
                                <h3 class="heading mb-20">Testimonials</h3>
                                <h6 class="section-sub-title mb-20">Why do people praise about<span class="" style="color:#2f3f58;"> Smugglers?</span></h6>
                            </div>
                            <div class="testimonial-slider">
                                <div class="swiper-container testimonial-slider__container-two">
                                    <div class="swiper-wrapper testimonial-slider__wrapper" style="height: auto;">
                                        @foreach($testimonials as $testimonial)
                                        <div class="swiper-slide">
                                            <div class="testimonial-slider__single wow move-up">
                                                <p class="mt-3 mb-3">{{ $testimonial->text }}</p>
                                                <div class="author-info">
                                                    <div class="testimonial-slider__media">
                                                        <img src="{{ url($testimonial->image) }}" class="img-fluid" alt="">
                                                    </div>
                                                    <div class="testimonial-slider__author">
                                                        <h6 class="heading">{{ $testimonial->name }}</h6>
                                                        <span class="designation">{{ $testimonial->store }}</span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="swiper-pagination swiper-pagination-t0 section-space--mt_40"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--====================  End of testimonial section  ====================-->


<!--===========  panel slider  start =============-->
<main id="main">
  <div data-w-id="122f97d3-501b-db74-4f56-f322d0d3b3ec" class="home_track">      

    <div class="home_camera">
      <div class="eyebrow u-text-center workflow">How it works</div>
      <div class="wrap__sticky sticky">
        <div class="container">
          <div class="stepper-wrap">
              @foreach($journey as $index => $journeys)
                  <div class="step-block {{ $index === 0 ? 'active' : '' }}">
                      <a id="slink{{ $index + 1 }}" data-scroll="{{ 900 + ($index * 1400) }}" href="#" class="tab_menu-btn btn cc-secondary cc-small w-inline-block">
                          <div>{{ $journeys->heading }}</div> <!-- Fetching the heading from the journey -->
                      </a>
                      <div class="step-block__progress-bar">
                          <div class="step-block__progress-bar-inner progress-bar__{{ $index + 1 }}"></div>
                      </div>
                  </div>
              @endforeach
          </div>
      </div>

      </div>
      <div class="home_frame">
        @foreach($journey as $index => $journeys)
    <div id="workflow-{{ $index + 1 }}" class="home_item {{ $index === 0 ? 'first' : '' }}">
        <div class="home_item-content_wrap">
            <div class="col col-lg-5">
                <div>
                    <div class="txt-chip cc-color-blueberry-400">
                        <div class="text-small">{{ $journeys['label'] }}</div>
                    </div>
                    <h2 class="h3 u-mt-1">{{ $journeys['heading'] }}</h2>
                    <p class="u-mt-1 u-mb-1">{!! $journeys['text'] !!}</p>
                    <a animaton-style="default" href="{{ $journeys['link'] }}" class="btn w-inline-block">
                        <div>{{ $journeys['button'] }}</div>
                    </a>
                </div>
            </div>
            @if ($index === 0)
           <div class="col col-lg-6">
            @else
           <div class="col col-lg-8">
            @endif
    <div class="u-product_container u-z-index-1 cc-dropshadow">
        <div class="clay_table w-embed">
 @if (in_array(pathinfo($journeys->path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'PNG']))
                <img src="{{ url($journeys['path']) }}" style="max-width: 100%; margin-bottom: -12px; width: 100%;">
@elseif (in_array(pathinfo($journeys->path, PATHINFO_EXTENSION), ['mp4', 'avi', 'mov','webm']))
            <video src="{{ $journeys['path'] }}" autoplay playsinline loop muted data-video="true" preload="none" style="max-width: 100%;"></video>
            @endif
        </div>
    </div>
</div>

        
        <!-- Additional Images Based on Index -->
        @if ($index === 0)
        </div>
        @elseif ($index === 1)
        </div>
            <img src="{{ url('images/rop1.webp') }}" loading="lazy" sizes="(max-width: 991px) 100vw, 853.046875px" srcset="{{ url('images/rop1.webp') }}" alt="" class="workflow-cord enrichment"/>
        @elseif ($index === 2)
        </div>
            <img src="{{ url('images/rop2.webp') }}" loading="lazy" sizes="(max-width: 991px) 100vw, 1030.03125px" srcset="{{ url('images/rop2.webp') }}" alt="" class="workflow-cord ai"/>
        @elseif ($index === 3)
            <img src="{{ url('images/rop4.webp') }}" loading="lazy" sizes="(max-width: 991px) 100vw, 685.78125px" srcset="{{ url('images/rop4.webp') }}" alt="" class="workflow-cord last"/>
            <img src="{{ url('images/rop3.webp') }}" loading="lazy" sizes="(max-width: 991px) 100vw, 910.03125px" srcset="{{ url('images/rop3.webp') }}" alt="" class="workflow-cord msg"/>
            </div>
        @endif
    </div>
@endforeach

      
      </div>
    </div>
  
  </div>
</main>

<!--===========  panel slider End =============-->


                
            </div>
        </div>




        <!--====================  footer area ====================-->
        <div class="footer-area-wrapper" style="background-color:#df9242;">
            <div class="footer-copyright-area" style="padding:10px;">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-12 text-center text-md-start">
                            <p class="copyright-ptext" style="text-align: center;
    color: white;
    font-size: 19px;">Copyright © 2024 Smugglers</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--====================  End of footer area  ====================-->








<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/hiw.js') }}" type="text/javascript"></script> 
@include('layouts.lead_form')
@include('layouts.footer_home')


<script type="text/javascript">
$(document).on('click','#lead_form_next',function(){
    const firstName = document.getElementById("first_name");
    const lastName = document.getElementById("last_name");
    const phoneNumber = document.getElementById("phone_number");
    const email = document.getElementById("email");
     function validateEmail(email) {
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return emailPattern.test(email);
    }
    if (firstName.value.trim() === "" || 
            lastName.value.trim() === "" || 
            phoneNumber.value.trim() === "" || 
            email.value.trim() === "") {

            alert("Please fill in all required fields.");
        }
         else if (!validateEmail(email.value.trim())) {
            alert("Please enter a valid email address.");
        } 
         else {
        $('#lead_form_one').hide();
        $('#lead_form_two').show();
        }
})
$('#multi-step-form').submit(function(e) {
        e.preventDefault();
        $('.error_invalid_lead_lic').hide();
        $('.error_invalid_lead').hide();
        $('.success_lead').hide();
        var storeName = $('#store_names').val();
        var licenseNumber = $('#store_license').val();
        var stateSelected = $('#statefetch').val();

        let formData = new FormData(this);
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
         $.ajax({
        // headers: {
        //     'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        // },
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        dataType: "json",
         success: function(data) {
            console.log(data);
            if(data.message == 'notmatch'){
            $('.error_invalid_lead_lic').show();
            }
            else{
                $('.success_lead').show();
                location.href="https://calendly.com/awilliams-mdq/smugglers-product-demo-q-a";
            }
        },
        error: function(err) {
            if (err.responseJSON && err.responseJSON.message) {
                console.log('Error message:', err.responseJSON.message);
                $('.error_invalid_lead p').text(err.responseJSON.message);
            } else if (err.responseText) {
                // Fallback in case responseJSON is not available
                console.log('Raw error response:', err.responseText);
                $('.error_invalid_lead p').text('An unexpected error occurred. Please try again.');
            } else {
                console.log('Unknown error:', err);
                $('.error_invalid_lead p').text('Something went wrong. Please contact support.');
            }
            $('.error_invalid_lead').show();
        }

    });
    });
function fetch_state_func(){
            $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
            });
        var url_statefetch_func = "{{ url('statefetch_func_home') }}";
          $.ajax({
        url: url_statefetch_func,
        type: 'POST',
         success: function(data) {
            console.log(data);
            if (data.response && data.response.results && data.response.results.data) {
                var states = data.response.results.data;
                var $select = $('#statefetch');
                
                // Clear existing options
                $select.empty();
                
                // Add default option
                $select.append('<option value="">Select State</option>');
                
                // Loop through the states array and append options
                $.each(states, function(index, state) {
                    $select.append('<option value="' + state.display_name + '" data-id="' + state.name + '">' + state.display_name + '</option>');
                });
            } else {
                console.error('Invalid data format', data);
            }
        },
        error: function(err) {
            console.log(err)
        }
    });
        }

        $(document).on('change','#statefetch',function() {
            var stateget_val = $(this).find('option:selected').text();
            var stateget_id = $(this).find('option:selected').attr('data-id');
            var stateget_val1 = $(this).val();
            $('.store_license_div').hide();
            $('.spinner_license_text').show();
            if (stateget_val == 'Select State') {
                 $('#store_license').unmask();
                 $('#store_license').val('')
                 $('#store_license').attr('placeholder', 'License Number');
                 $('#state_old').val('');
                 $('.spinner_license_text').hide();
            }
            else{
            $('#state_old').val(stateget_id);
            $('.spinner_license').show();
            $('#store_license').attr('readonly','readonly')
            $('#store_license').val('')
            $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
            });
        var url_statefetch = "{{ url('stateget_change_home') }}";
          $.ajax({
        url: url_statefetch,
        type: 'POST',
        data: {stateget_val : stateget_val},
        // processData: false,
        // contentType: false,
        // cache: false,
        // dataType: "json",
         success: function(data) {
            console.log(data);
            console.log(data.message.license_no);
            $('#store_names').empty();

             // Check if store names are available
            if (data.storename && data.storename.length > 0) {
                // Append a default "Select a Store" option
                $('#store_names').append('<option value="">Select a Store</option>');
                
                // Loop through the store names and append them to the select dropdown
                $.each(data.storename, function(index, storeName) {
                    $('#store_names').append('<option value="' + storeName + '">' + storeName + '</option>');
                });
            } else {
                // If no stores are found, show a placeholder
                $('#store_names').append('<option value="">No stores available</option>');
            }

            if(data.message.license_no === undefined){
                $('#store_license').unmask();
                 $('#store_license').val('')
                 $('#store_license').attr('placeholder', 'License Number');
            $('.spinner_license').hide();
            $('.spinner_license_text').hide();
            $('#store_license').removeAttr('readonly')
            }
            else{
            var maskFormat = data.message.license_no.replace(/[A-Za-z]/g, 'A').replace(/[0-9]/g, '0');
            applyMask(maskFormat);
            $('.store_license_div').show();
            $('.spinner_license').hide();
            $('.spinner_license_text').hide();
            $('#store_license').removeAttr('readonly')
            }
        },
        error: function(err) {
            console.log(err)
            $('.spinner_license').hide();
            $('#store_license').removeAttr('readonly');
        }
    });
      }
        })

        function applyMask(format_type) {
            $('#store_license').mask(format_type, {
                'translation': {
                    A: { pattern: /[A-Za-z]/ }, // A for any letter
                    0: { pattern: /[0-9]/ }     // 0 for any digit
                }
            });

            var placeholder = format_type.replace(/A/g, 'X').replace(/0/g, '1');
            $('#store_license').attr('placeholder', placeholder);
        }

    $(document).ready(function() {
        fetch_state_func()
        var modal = document.querySelector(".modal_form");
        var triggers = document.querySelectorAll(".click_all_learnmore");
        var closeButton = document.querySelector(".close-button_form");

        function toggleModal() {
            const firstName = document.getElementById("first_name").value.trim();
            const lastName = document.getElementById("last_name").value.trim();
            const phoneNumber = document.getElementById("phone_number").value.trim();
            const email = document.getElementById("email").value.trim();

        if (firstName && lastName && phoneNumber && email) {
        // If all fields are filled, submit the form
        $('#multi-step-form').submit(); 
        }

        modal.classList.toggle("show-modal_form");
    
        }

        function windowOnClick(event) {
          if (event.target === modal) {
            toggleModal();
          }
        }

        for (var i = 0, len = triggers.length; i < len; i++) {
          triggers[i].addEventListener("click", toggleModal);
        }
        closeButton.addEventListener("click", toggleModal);
        window.addEventListener("click", windowOnClick);

        

      $(document).on('click','.click_reg_a',function(){
        var id = $(this).data('id');
        var url_reg = "{{ url('register') }}/" + id;
        location.href = url_reg;
      })


    $('.click_change_plan_upd').on('click', function() {
    var planId = $(this).data('id');
    var planName = $(this).closest('.price_main_column').find('h5').text().trim(); // Get and trim the plan name

    // Show a confirmation dialog
    var confirmMessage = `Are you sure you want to change your plan to ${planName}? This action will ${planId ? 'upgrade' : 'downgrade'} your current plan.`;
    var confirmed = confirm(confirmMessage);

    if (confirmed) {
        // Proceed with the AJAX request if confirmed
        $.ajax({
            url: '{{ route("change_plan") }}',
            type: 'POST',
            data: {
                plan_id: planId,
                _token: '{{ csrf_token() }}' // Include CSRF token for security
            },
            success: function(response) {
                // Optionally, you can reload the page or update the UI
                location.reload();
            },
            error: function(xhr) {
                alert('An error occurred: ' + xhr.responseJSON.error);
            }
        });
    } else {
        // User canceled the action
        console.log('Plan change canceled.');
    }

});
  
    $('.click_change_plan').on('click', function() {
    var planId = $(this).data('id');
    var planName = $(this).closest('.price_main_column').find('h5').text().trim(); // Get and trim the plan name

    
        // Proceed with the AJAX request if confirmed
        $.ajax({
            url: '{{ route("starting_plan_set") }}',
            type: 'POST',
            data: {
                plan_id: planId,
                _token: '{{ csrf_token() }}' // Include CSRF token for security
            },
            success: function(response) {
                // Optionally, you can reload the page or update the UI
                location.href = 'add_a_card';
            },
            error: function(xhr) {
                alert('An error occurred: ' + xhr.responseJSON.error);
            }
        });
});

});


    

    $(document).ready(function(){
  $(".learn-more").click(function(){
    $(".contentp").slideToggle();
    $(".learn-more").text(function(i, text){
      return text === "Learn More" ? "Show Less" : "Learn More";
    });
  });
});

    $(document).ready(function(){
  $(".learn-more2").click(function(){
    $(".contentp2").slideToggle();
    $(this).text(function(i, text){
      return text === "Learn More" ? "Show Less" : "Learn More";
    });
  });
});

    $(document).ready(function(){
  $(".learn-more2").click(function(){
    $(".contentp3").slideToggle();
    $(this).text(function(i, text){
      return text === "Learn More" ? "Show Less" : "Learn More";
    });
  });
});
</script>



</html>
@endsection

