<div class="widget">
    <h2>Il Fustometro</h2>
    <h3>Fusti assegnati</h3>
    <div class="fustiassegnati">
        <div class=fustiassegnaticontent>
            <div id="count-example"></div>
        </div>    
        <div class="lista">
            <ul>
                <li>Andrea Rotondo</li>
                <li>Filippo Pagliarella</li>
            </ul>
        </div>
    </div>
    <h3>Fusti in preparazione</h3>
    <div class="fusticoming">
    </div>
    <?php 
       
       
    ?>
    <script>
        $('#count-example').jQuerySimpleCounter({
            start:  30,
            end:    0,
            easing:'easeOutExpo',
            duration: 5000
        });
    </script>
    <!-- <script>
        (function($) {
            $.fn.countTo = function(options) {
            // merge the default plugin settings with the custom options
            options = $.extend({}, $.fn.countTo.defaults, options || {});

            // how many times to update the value, and how much to increment the value on each update
            var loops = Math.ceil(options.speed / options.refreshInterval),
                increment = (options.to - options.from) / loops;

            return $(this).each(function() {
                var _this = this,
                    loopCount = 0,
                    value = options.from,
                    interval = setInterval(updateTimer, options.refreshInterval);

                function updateTimer() {
                    value += increment;
                    loopCount++;
                    $(_this).html(value.toFixed(options.decimals));

                    if (typeof(options.onUpdate) == 'function') {
                        options.onUpdate.call(_this, value);
                    }

                    if (loopCount >= loops) {
                        clearInterval(interval);
                        value = options.to;

                        if (typeof(options.onComplete) == 'function') {
                            options.onComplete.call(_this, value);
                        }
                    }
                }
            });
        };

            $.fn.countTo.defaults = {
                from: 0,  // the number the element should start at
                to: 100,  // the number the element should end at
                speed: 1000,  // how long it should take to count between the target numbers
                refreshInterval: 100,  // how often the element should be updated
                decimals: 0,  // the number of decimal places to show
                onUpdate: null,  // callback method for every time the element is updated,
                onComplete: null,  // callback method for when the element finishes updating
            };
        })(jQuery);

        jQuery(function($) {
                $('.timer').countTo({
                    from: 100,
                    to: 10,
                    speed: 2000,
                    refreshInterval: 50,
                    onComplete: function(value) {
                        // console.debug(this);
                    }
                });
            });
        </script> -->
    <hr>
</div>