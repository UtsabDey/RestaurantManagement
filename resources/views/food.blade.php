<!-- ***** Menu Area Starts ***** -->
    <section class="section" id="menu">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="section-heading">
                        <h6>Our Menu</h6>
                        <h2>Our selection of cakes with quality taste</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu-item-carousel">
            <div class="col-lg-12">
                <div class="owl-menu-item owl-carousel">
                    @foreach ($lists as $list)
                    <form action="{{ url('/addcart', $list->id) }}" method="POST">
                        @csrf
                    <div class="item">
                        <div style="background-image: url('/foodimage/{{ $list->image }}')" class='card'>
                            <div class="price"><h6>${{ $list->price }}</h6></div>
                            <div class='info'>
                              <h1 class='title'>{{ $list->title }}</h1>
                              <p class='description'>{{ $list->description }}</p>
                              <div class="main-text-button">
                                  <div class="scroll-to-section"><a href="#reservation">Make Reservation <i class="fa fa-angle-down"></i></a></div>
                              </div>
                            </div>
                        </div>
                        <input type="number" name="quantity" min="1" style="width: 110px" placeholder="Quantity">&nbsp;&nbsp;
                        <input type="submit" class="btn btn-success" value="Add Cart">
                    </div>  
                    </form> 
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Menu Area Ends ***** -->