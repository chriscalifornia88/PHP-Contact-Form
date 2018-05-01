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
                <small class="pull-right">* indicates required fields</small>
                <div class="clearfix"></div>
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="name">Full Name *</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="email">Email *</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="email" required/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="message">Phone</label>
                        <div class="col-sm-10">
                            <input type="tel" class="form-control" id="phone" name="phone"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="message">Message *</label>
                        <div class="col-sm-10">
                            <textarea rows="7" type="text" class="form-control" id="message" name="message" required></textarea>
                        </div>
                    </div>
                    <input type="submit" class="pull-right btn btn-primary" name="submit" value="Send"/>
                </form>
            </div>
        </div>
    </section>
@endpush