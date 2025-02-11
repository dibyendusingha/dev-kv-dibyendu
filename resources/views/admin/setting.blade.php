@extends('admin.layout.main')
@section('page-container')
<?php
use Illuminate\Support\Facades\DB;
?>

            <section class="content-main">
                <div class="content-header">
                    <h2 class="content-title">Setting</h2>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row gx-5">
                            <div class="col-lg-12">
                                <section class="content-body p-xl-4">
                                    <form>
                                        <div class="row border-bottom mb-4 pb-4">
                                            <div class="col-md-5">
                                                <h5>Access</h5>
                                                <p class="text-muted" style="max-width: 90%">Give access of all pages including each product lorem ipsum dolor sit amet, consectetur adipisicing</p>
                                            </div>
                                            <!-- col.// -->
                                            <div class="col-md-7">
                                                <label class="mb-2 form-check">
                                                    <input class="form-check-input" checked="" name="mycheck_a1" type="radio" />
                                                    <span class="form-check-label"> All registration is enabled </span>
                                                </label>
                                                <label class="mb-2 form-check">
                                                    <input class="form-check-input" name="mycheck_a1" type="radio" />
                                                    <span class="form-check-label"> Only buyers is enabled </span>
                                                </label>
                                                <label class="mb-2 form-check">
                                                    <input class="form-check-input" name="mycheck_a1" type="radio" />
                                                    <span class="form-check-label"> Only buyers is enabled </span>
                                                </label>
                                                <label class="mb-2 form-check">
                                                    <input class="form-check-input" name="mycheck_a1" type="radio" />
                                                    <span class="form-check-label"> Stop new shop registration </span>
                                                </label>
                                            </div>
                                            <!-- col.// -->
                                        </div>
                                        <!-- row.// -->
                                        <div class="row border-bottom mb-4 pb-4">
                                            <div class="col-md-5">
                                                <h5>Notification</h5>
                                                <p class="text-muted" style="max-width: 90%">Lorem ipsum dolor sit amet, consectetur adipisicing something about this</p>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" value="" id="mycheck_notify" checked />
                                                    <label class="form-check-label" for="mycheck_notify"> Send notification on each user registration </label>
                                                </div>
                                                <div class="mb-3">
                                                    <input class="form-control" placeholder="Text" />
                                                </div>
                                            </div>
                                            <!-- col.// -->
                                        </div>
                                        <!-- row.// -->
                                        <div class="row border-bottom mb-4 pb-4">
                                            <div class="col-md-5">
                                                <h5>Currency</h5>
                                                <p class="text-muted" style="max-width: 90%">Lorem ipsum dolor sit amet, consectetur adipisicing something about this</p>
                                            </div>
                                            <!-- col.// -->
                                            <div class="col-md-7">
                                                <div class="mb-3" style="max-width: 200px">
                                                    <label class="form-label">Main currency </label>
                                                    <select class="form-select">
                                                        <option>US Dollar</option>
                                                        <option>EU Euro</option>
                                                        <option>RU Ruble</option>
                                                        <option>UZ Som</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3" style="max-width: 200px">
                                                    <label class="form-label">Supported curencies</label>
                                                    <select class="form-select">
                                                        <option>US dollar</option>
                                                        <option>RUBG russia</option>
                                                        <option>INR india</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- col.// -->
                                        </div>
                                        <!-- row.// -->
                                        <button class="btn btn-primary" type="submit">Save all changes</button> &nbsp;
                                        <button class="btn btn-light rounded font-md" type="reset">Reset</button>
                                    </form>
                                </section>
                                <!-- content-body .// -->
                            </div>
                            <!-- col.// -->
                        </div>
                        <!-- row.// -->
                    </div>
                    <!-- card body end// -->
                </div>
                <!-- card end// -->
            </section>
            
@endsection            
