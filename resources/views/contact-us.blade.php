@extends('layouts.app')
@section('content')
<div class="container"><!-- /#content.container -->    
    <div class="row">
        <div class="col-sm-12">
            <h2>Contact Us <small></small></h2>
            <hr class="colorgraph">
        </div>
        <div class="">
            <div class="col-xs-12 col-md-12 col-centered">
                <div class="divcontainer">
                    <form name="contactForm" role="form" action="javascript:void(0);" ng-submit="submitContact(contactForm.$valid)" novalidate>
                        {{ csrf_field()}}
                        <!--<h2>Contact Us <small></small></h2>-->
                        <!--<hr class="colorgraph">-->
                        <div class="form-group" ng-class="{ 'has-error' : contactForm.inquiry.$invalid && !contactForm.inquiry.$pristine }">
                            <label for="inquiry">Nature of inquiry:<span class="required">*</span> </label>
                            <select class="form-control" name="inquiry" required="" ng-model="contact.inquiry">
                                <option value="">Choose...</option>
                                <option value="Pre-order Question">Pre-order Question</option>
                                <option value="Question About My Order">Question About My Order</option>
                                <option value="Suggestions/Comments">Suggestions/Comments</option>
                                <option value="Returns">Returns</option>
                            </select>
                            <span ng-show="contactForm.inquiry.$invalid && !contactForm.inquiry.$pristine" class="help-block">
                                <strong>Please select inquiry.</strong>
                            </span> 
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : contactForm.name.$invalid && !contactForm.name.$pristine }">
                            <label for="name">Your Name:<span class="required">*</span> </label>
                            <input type="text" name="name" required="" ng-model="contact.name"  class="form-control" placeholder="Your Name">
                            <span ng-show="contactForm.name.$invalid && !contactForm.name.$pristine" class="help-block">
                                <strong>Please enter your name.</strong>
                            </span> 
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : contactForm.company_name.$invalid && !contactForm.company_name.$pristine }">
                            <label for="company_name">Company Name:<span class="required"></span> </label>
                            <input type="text" name="company_name" ng-model="contact.company_name" class="form-control" placeholder="Company Name">
                            <span ng-show="contactForm.company_name.$invalid && !contactForm.company_name.$pristine" class="help-block">
                                <strong>Please enter company name.</strong>
                            </span> 
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : contactForm.email.$invalid && !contactForm.email.$pristine }">
                            <label for="email">Email Address:<span class="required">*</span> </label>
                            <input type="email" name="email" required="" ng-model="contact.email" class="form-control" placeholder="Email Address">
                            <span ng-show="contactForm.email.$invalid && !contactForm.email.$pristine" class="help-block">
                                <strong>Please enter email address.</strong>
                            </span> 
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : contactForm.order_number.$invalid && !contactForm.order_number.$pristine }">
                            <label for="order_number">Order Number:<span class="required"></span> </label>
                            <input type="text" name="order_number" ng-model="contact.order_number" class="form-control" placeholder="Order Number">
                            <span ng-show="contactForm.order_number.$invalid && !contactForm.order_number.$pristine" class="help-block">
                                <strong>Please enter order number.</strong>
                            </span> 
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : contactForm.item_number.$invalid && !contactForm.item_number.$pristine }">
                            <label for="item_number">Item Number:<span class="required"></span> </label>
                            <input type="text" name="item_number" ng-model="contact.item_number" class="form-control" placeholder="Item Number">
                            <span ng-show="contactForm.item_number.$invalid && !contactForm.item_number.$pristine" class="help-block">
                                <strong>Please enter item number.</strong>
                            </span> 
                        </div>
                        <div class="form-group" ng-class="{ 'has-error' : contactForm.message.$invalid && !contactForm.message.$pristine }">
                            <label for="message">Message/Comments:<span class="required">*</span> </label>
                            <textarea class="form-control" name="message" cols="6" required="" rows="6" ng-model="contact.message" placeholder="Message/Comments"></textarea>
                            <span ng-show="contactForm.message.$invalid && !contactForm.message.$pristine" class="help-block">
                                <strong>Please enter your message.</strong>
                            </span> 
                        </div>
                        <div class="form-group">
                            <hr class="colorgraph">
                            <button class="btn btn-lg am-orange hover material" id="btnContactUs" elevation="1" type="submit">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


