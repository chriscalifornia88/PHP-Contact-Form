@push('menu')
    <li>
        <a class="page-scroll" href="#contact">Contact</a>
    </li>
@endpush

@push('content')
    <!-- Contact Section -->
    <section id="contact" class="container content-section text-center">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <h2>Contact Guy Smiley</h2>
                <p>Remember Guy Smiley? Yeah, he wants to hear from you.</p>
                <small class="pull-right">* indicates a required field</small>
                <div class="clearfix"></div>
                <form action="{{ url('contact') }}" method="post" id="contact-form" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label class="col-sm-2 control-label" for="name">Full Name *</label>
                        <div class="col-sm-10">
                            <input value="{{ old('name') }}" type="text" class="form-control" id="name" name="name" required/>
                            <small class="help-block" style="text-align: left">{{ $errors->first('name') }}</small>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label class="col-sm-2 control-label" for="email">Email *</label>
                        <div class="col-sm-10">
                            <input value="{{ old('email') }}" type="email" class="form-control" id="email" name="email" required/>
                            <small class="help-block" style="text-align: left">{{ $errors->first('email') }}</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="message">Phone</label>
                        <div class="col-sm-10">
                            <input value="{{ old('phone') }}" type="tel" class="form-control" id="phone" name="phone"/>
                            <small class="help-block" style="text-align: left">{{ $errors->first('phone') }}</small>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
                        <label class="col-sm-2 control-label" for="message">Message *</label>
                        <div class="col-sm-10">
                            <textarea rows="7" type="text" class="form-control" id="message" name="message" required>{{ old('message') }}</textarea>
                            <small class="help-block" style="text-align: left">{{ $errors->first('message') }}</small>
                        </div>
                    </div>
                    <input type="submit" class="pull-right btn btn-primary" name="submit" value="Send"/>
                </form>
            </div>
        </div>
    </section>
@endpush