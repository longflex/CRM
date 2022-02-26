<div class="dialbox text-center p-0 m-0 stopwatch" id="DIS">
    <button class="btn btn-rounded btn-outline-warning float-right px-1 py-0 m-2" id="btnminus" type="button" data-toggle="tooltip" data-original-title="Minimize"><i class="uil-minus"></i></button>
    <button class="btn btn-rounded btn-outline-primary float-left px-1 py-0 m-2" data-id="play" id="pause-play" type="button" data-toggle="tooltip" data-original-title="Take Break"><i class="uil-pause"></i></button>
    <!-- <button id="BREAK" class="btn btn-rounded btn-outline-primary float-left px-1 py-0 m-2 toggle"  data-original-title="Take Break" data-pausetext="Pause" data-resumetext="Resume">Start</button> -->
    <!-- <div class="mt-2">Break Time <span class="minutes"></span> : <span class="seconds"></span></div> -->
    <div class="mt-2">Break No. (<span class="countbreak"></span>) Time - <span class="countdown"></span></div>
    <!-- <div class="stopwatch" data-autostart="false">
        <div class="time">
            <span class="hours"></span> : 
            <span class="minutes"></span> : 
            <span class="seconds"></span> :: 
            <span class="milliseconds"></span>
        </div>
        <div class="controls">
            <button class="toggle" data-pausetext="Pause" data-resumetext="Resume">Start</button>
            <button class="reset">Reset</button>
        </div>
    </div> -->
    <div class="clearfix"></div>
    <div id="Showcall" class="showcall text-center p-4 pb-5 m-0">
        <h4 class="text-center"><span id="call-title"></span>&nbsp;</h4><br>
        <h3 class="text-center"><span id="Dailing"></span>&nbsp;</h3>
        <!-- <h3 class="text-center"><span id="call-countdown"></span>&nbsp;</h3><br> -->
        <h3 class="text-center"><span id="call-details"></span>&nbsp;</h3><br>
        <h5 class="text-center"><span id="DISMSG"></span>&nbsp;</h5><br>
    </div>
    <div id="Dialer" class="p-0 m-0">
        <div class="text-right px-2 m-0">
            <h3><input id="dialnum" type="number" class="text-right form-control"/></h3>
        </div>
        <div class="p-2">
            <div class="row no-gutters">
                <div class="col">
                    <a class="btn btn-rounded btn-outline-primary" id="ONE">1</a>
                </div>
                <div class="col">
                    <a class="btn btn-rounded btn-outline-primary" id="TWO">2</a>
                </div>
                <div class="col">
                    <a class="btn btn-rounded btn-outline-primary" id="THREE">3</a>
                </div>
            </div>
        </div>
        <div class="p-2">
            <div class="row no-gutters">
                <div class="col">
                    <a class="btn btn-rounded btn-outline-primary" id="FOUR">4</a>
                </div>
                <div class="col">
                    <a class="btn btn-rounded btn-outline-primary" id="FIVE">5</a>
                </div>
                <div class="col">
                    <a class="btn btn-rounded btn-outline-primary" id="SIX">6</a>
                </div>
            </div>
        </div>
        <div class="p-2">
            <div class="row no-gutters">
                <div class="col">
                    <a class="btn btn-rounded btn-outline-primary" id="SEVEN">7</a>
                </div>
                <div class="col">
                    <a class="btn btn-rounded btn-outline-primary" id="EIGHT">8</a>
                </div>
                <div class="col">
                    <a class="btn btn-rounded btn-outline-primary" id="NINE">9</a>
                </div>
            </div>
        </div>
        <div class="p-2">
            <div class="row no-gutters">
                <div class="col">
                    <a class="btn btn-rounded btn-outline-primary" id="DELE">
                        <i class="uil-backspace"></i>
                    </a>
                </div>
                <div class="col">
                    <a class="btn btn-rounded btn-outline-primary" id="ZERO">0</a>
                </div>
                <div class="col">
                    <a class="btn btn-rounded btn-outline-primary" id="HASH">#</a>
                </div>
            </div>
        </div>
    </div>
    <div class="px-2 m-2">
        <div class="row no-gutters">
            <div class="col">
                <button id="CALLING" data-id="auto" class="btn btn-lg btn-block btn-rounded btn-info" data-toggle="tooltip" title="" data-original-title="Auto Calling"><i class="uil-calling"></i></button>
            </div>
            <div class="col">
                <button id="CALLEND" data-id="call" class="btn btn-lg btn-block btn-rounded btn-success" data-toggle="tooltip" title="" data-original-title="Start Call"><i class="uil-forwaded-call"></i></button>
            </div>
        </div>
    </div>
</div>
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <script>document.write(new Date().getFullYear())</script> © 
                <a href="javascript: void(0);">{{ config('app.name') }}</a>
            </div>
            <div class="col-md-6">
                <div class="text-md-right footer-links d-none d-md-block">
                    <a href="javascript: void(0);">About</a>
                    <a href="javascript: void(0);">Support</a>
                    <a href="javascript: void(0);">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</footer>