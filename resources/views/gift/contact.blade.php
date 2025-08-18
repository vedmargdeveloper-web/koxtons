@extends( _app() )

@section('content')


<!-- Page Content Wraper -->
<div class="page-content-wraper">
    <!-- Bread Crumb -->
    <section class="">
            <div class="container">
                <div class="row">
                    <div class="col-12 mt-10">
                        <nav class="breadcrumb-link" style="margin-left:15px; display: flex; align-items: center; flex-wrap: wrap; color: #555; font-size: 14px;">
                            <a href="{{ url('/') }}" style="color: #007bff; text-decoration: none;">Home</a>

                                <span style="margin: 0 5px;">&raquo;</span>
                                <span>Contact Us</span>
                           
                        </nav>
                    </div>
                </div>
            </div>
        </section>

    <!-- Bread Crumb -->

    <!-- Page Content -->
    <section class="content-page bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="map style1 mb-45">
                        <?php echo App\model\Meta::where('meta_name', 'location')->value('meta_value'); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-xs-30">
                    <h1 class="normal"><span>Stay In Touch</span></h1>
                    <p class="mb-25">We are always here to help your. stay in touch</p>
                    <h3>Company address</h3>
                    <?php echo App\model\Meta::where('meta_name', 'address')->value('meta_value'); ?>
                    <h3>Contact Information</h3>
                    <ul class="Contact-information mb-25">
                        <li><i class="fa fa-envelope" aria-hidden="true"></i><?php echo App\model\Meta::where('meta_name', 'contact_email')->value('meta_value'); ?></li>
                        <li style="display: none;"><i class="fa fa-phone" aria-hidden="true"></i><?php echo App\model\Meta::where('meta_name', 'phone')->value('meta_value'); ?></li>
                        <li><i class="fa fa-whatsapp" aria-hidden="true"></i><?php echo App\model\Meta::where('meta_name', 'whatsapp')->value('meta_value'); ?></li>
                    </ul>
                    <hr />
                    <?php $whatsapp = App\model\Meta::where('meta_name', 'whatsapp')->value('meta_value'); ?>
                    <div class="product-share mtb-30">
                        <h3>FOLLOW US</h3>
                        <ul class="list-none">
                            <li><a href="https://www.facebook.com/{{ App\model\Meta::where('meta_name', 'facebook')->value('meta_value') }}" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            <li>
                                <a href="https://twitter.com/{{ App\model\Meta::where('meta_name', 'twitter')->value('meta_value') }}" target="_blank">
                                    <span class="icon-wrapper">
                                        <svg class="fa-twitter" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox=" 0 -5 30 30">
                                            <path d="M26.37,26l-8.795-12.822l0.015,0.012L25.52,4h-2.65l-6.46,7.48L11.28,4H4.33l8.211,11.971L12.54,15.97L3.88,26h2.65 l7.182-8.322L19.42,26H26.37z M10.23,6l12.34,18h-2.1L8.12,6H10.23z"></path>
                                        </svg>
                                    </span>
                                </a>
                            </li>
                    
                            <li><a href="https://instagram.com/{{ App\model\Meta::where('meta_name', 'instagram')->value('meta_value') }}" target="_blank"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="https://www.linkedin.com/in/{{ App\model\Meta::where('meta_name', 'linkedin')->value('meta_value') }}" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>

                            <li><a href="https://wa.me/<?=$whatsapp ? $whatsapp :'#'; ?>?text=Hi%20Koxton%0A%0AI%20am%20interested%20in%20your%20product%0A%0AMy%20name%20is%20" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i> </a></li>

                        </ul>
                    </div>

                </div>
                <div class="col-md-6 offset-md-2">
                    <h1 class="normal"><span>Contact Us</span></h1>
                    <form class="Contact-form" id="contactForm1" method="post" action="{{ route('contact') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-field-wrapper">
                                    <label>Your Name <span class="required">*</span></label>
                                    <input id="author" class="input-md form-full-width" name="name" placeholder=" Enter Your Name" value="{{ Auth::check() ? Auth::user()->first_name.' '.Auth::user()->last_name : '' }}" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-field-wrapper">
                                    <label>Your Email <span class="required">*</span></label>
                                    <input id="author-email" class="input-md form-full-width" name="email" placeholder="Enter Your Email Address" value="{{ Auth::check() ? Auth::user()->email : '' }}"  type="email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-field-wrapper">
                                    <label>Your subject <span class="required">*</span></label>
                                    <input id="subject" class="input-md form-full-width" name="subject" placeholder="Enter Your Subject" value="" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-field-wrapper">
                                    <label>Your Mobile <span class="required">*</span></label>
                                    <input id="author-email" class="input-md form-full-width" name="mobile" placeholder="Enter Your Mobile No" value="{{ Auth::check() ? Auth::user()->mobile : '' }}"  type="number">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-field-wrapper">
                                    <label>Comments<span class="required">*</span></label>
                                    <textarea id="comment" class="form-full-width" name="message" placeholder="Enter Your Message" cols="45" rows="8" ></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-field-wrapper">
                            <input name="submit" id="submit" class="submit btn btn-md btn-color" value="Submit" type="submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection