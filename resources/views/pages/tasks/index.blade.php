@extends('layouts.app')
@section('title', 'Task List')
@section('breadcrumb-main', 'Task')
@section('breadcrumb-sub', 'List')

@section('content')

<div class="layout-px-spacing">
    <div class="row layout-spacing layout-top-spacing" id="cancel-row">
        <div class="col-lg-12">
            <div class="widget-content">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 ">
                        <div class="d-flex justify-content-sm-end justify-content-center">
                            <form class="form-inline">
                                <div class="switch align-self-center">
                                    <select class="selectpicker myClass mb-4">
                                        <option>Select Something</option>
                                    </select>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row layout-spacing">
        <!-- Content -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">

            <div class="education layout-spacing ">
                <div class="widget-content widget-content-area">
                    <h3 class="ml-3 mt-3 ">Shibbir ( Senior Support)</h3>
                    <span class="badge badge-primary ml-3"> Primary </span>
                    <span class="badge badge-primary ml-3"> Primary </span>
                    <span class="badge badge-primary ml-3"> Primary </span>
                    <div class="timeline-alter ml-3">
                        <div class="item-timeline">
                            <div class="t-dot">
                            </div>
                            <div class="t-text">
                                <p>Royal Collage of Art</p>
                            </div>
                        </div>
                        <div class="item-timeline">

                            <div class="t-dot">
                            </div>
                            <div class="t-text">
                                <p>Massachusetts Institute of Technology (MIT)</p>
                            </div>
                        </div>
                        <div class="item-timeline">
                            <div class="t-dot">
                            </div>
                            <div class="t-text">
                                <p>School of Art Institute of Chicago (SAIC)</p>
                            </div>
                        </div>
                    </div>
                    <hr class="col-md-10" style="border-top: dotted 1px; " />

                    <span class="badge badge-primary ml-3"> Primary </span>
                    <span class="badge badge-primary ml-3"> Primary </span>
                    <span class="badge badge-primary ml-3"> Primary </span>
                    <div class="timeline-alter ml-3">
                        <div class="item-timeline">
                            <div class="t-dot">
                            </div>
                            <div class="t-text">
                                <p>Royal Collage of Art</p>
                            </div>
                        </div>
                        <div class="item-timeline">

                            <div class="t-dot">
                            </div>
                            <div class="t-text">
                                <p>Massachusetts Institute of Technology (MIT)</p>
                            </div>
                        </div>
                        <div class="item-timeline">
                            <div class="t-dot">
                            </div>
                            <div class="t-text">
                                <p>School of Art Institute of Chicago (SAIC)</p>
                            </div>
                        </div>
                    </div>
                    <hr />
                </div>

            </div>

            <div class="education layout-spacing ">
                <div class="widget-content widget-content-area">
                    <h3 class="ml-3 mt-3">Education</h3>
                    <span class="badge badge-primary ml-3"> Primary </span>
                    <div class="timeline-alter ml-3">
                        <div class="item-timeline">
                            <div class="t-dot">
                            </div>
                            <div class="t-text">
                                <p>Royal Collage of Art</p>
                                <p>Designer Illustrator</p>
                            </div>
                        </div>
                        <div class="item-timeline">

                            <div class="t-dot">
                            </div>
                            <div class="t-text">
                                <p>Massachusetts Institute of Technology (MIT)</p>
                                <p>Designer Illustrator</p>
                            </div>
                        </div>
                        <div class="item-timeline">
                            <div class="t-dot">
                            </div>
                            <div class="t-text">
                                <p>School of Art Institute of Chicago (SAIC)</p>
                                <p>Designer Illustrator</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="education layout-spacing ">
                <div class="widget-content widget-content-area">
                    <h3 class="ml-3 mt-3">Education</h3>
                    <span class="badge badge-primary ml-3"> Primary </span>

                    <div class="timeline-alter ml-3">
                        <div class="item-timeline">
                            <div class="t-dot">
                            </div>
                            <div class="t-text">
                                <p>Royal Collage of Art</p>
                                <p>Designer Illustrator</p>
                            </div>
                        </div>
                        <div class="item-timeline">

                            <div class="t-dot">
                            </div>
                            <div class="t-text">
                                <p>Massachusetts Institute of Technology (MIT)</p>
                                <p>Designer Illustrator</p>
                            </div>
                        </div>
                        <div class="item-timeline">
                            <div class="t-dot">
                            </div>
                            <div class="t-text">
                                <p>School of Art Institute of Chicago (SAIC)</p>
                                <p>Designer Illustrator</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>

    </div>
</div>

@endsection
