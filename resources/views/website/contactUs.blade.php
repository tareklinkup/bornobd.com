@extends('layouts.website')
@section('title', 'Contact Us')
@section('website-content')
    <section>
        <div class="container">
            <div class="row shadow m-4 rounded p-4">
                <h3 class="mb-4 inner-section" style="text-align: center;border-bottom: 1px solid;">Let's get in touch</h3>
                <div class="col-lg-7 col-md-7">
                    <form method="POST" action="{{ route('contact.store.website') }}">
                      @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group contact-from">
                                    <label class="label" for="name">Full Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" value="" name="name"
                                        placeholder="Name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group contact-from">
                                    <label class="label" for="email">Email Address *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" value="" name="email" placeholder="Email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group contact-from">
                                    <label class="label" for="subject">Subject *</label>
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror" value="" name="subject" placeholder="Subject">
                                    @error('subject')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group contact-from">
                                    <label class="label" for="#">Message</label>
                                    <textarea name="message" class="form-control" cols="30" rows="4" placeholder="Message"></textarea>
                               
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div class="form-group">
                                    <input type="submit" value="Send Message" class="btn contact-btn py-2">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-5 col-md-5 ps-4">
                    <div class="">
                        {{-- <h3 class="inner-section">Let's get in touch</h3> --}}
                        <br>
                        <p class="mb-4">We're open for any suggestion or just to have a chat</p>
                        <div class="vertical-align mb-3">
                            <div class="cotact-icon">
                                <span class="fas fa-map-marker-alt"></span>
                            </div>
                            <div class="text pl-3">
                                <p class="mb-0"><span>Address:</span> <a>{{ $content->address }}</a></p>
                            </div>
                        </div>
                        <div class="vertical-align mb-3">
                            <div class="cotact-icon">
                                <span class="fas fa-phone"></span>
                            </div>
                            <div class="text pl-3">
                                <p class="mb-0"><span>Phone:</span> <a
                                        href="tel://{{ $content->phone_1 }}">{{ $content->phone_1 }}</a></p>
                                <p class="mb-0"><span>Phone:</span> <a
                                        href="tel://{{ $content->phone_2 }}">{{ $content->phone_2 }}</a></p>
                            </div>
                        </div>
                        <div class="vertical-align mb-3">
                            <div class="cotact-icon">
                                <span class="fas fa-paper-plane"></span>
                            </div>
                            <div class="text pl-3">
                                <p class="mb-0"><span>Email:</span> <a
                                        href="mailto:{{ $content->email }}">{{ $content->email }}</a></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
