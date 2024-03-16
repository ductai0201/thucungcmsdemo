@extends('frontend.layouts.app')
@php
    $cart_added = [];
    $decoded_slider_images = json_decode(get_setting('home_slider_images', null, $lang), true);
    $sliders = get_slider_images($decoded_slider_images);
    $home_slider_links = get_setting('home_slider_links', null, $lang);
    $top_brands = json_decode(get_setting('top_brands'));
    $brands = get_brands($top_brands);

                                        
@endphp
@section('content')
    <style>
        @media (max-width: 767px){
            #flash_deal .flash-deals-baner{
                height: 203px !important;
            }
        }
    </style>
   
    @php $lang = get_system_language()->code;  @endphp
    <!-- Sliders -->
    <div class="container">
        <!-- Sliders -->
                <div class="home-banner-area mb-3" style="">
                    <div class="container">
                        <div class="row d-flex flex-nowrap h-280px mt-4">
                            <!-- Sliders -->
                                @if (get_setting('home_slider_images', null, $lang) != null)
                                        <!-- <swiper-container class="mySwiper col-8" pagination="true" pagination-clickable="true" navigation="true"
                                            space-between="30" centered-slides="true" autoplay-delay="2500"
                                            autoplay-disable-on-interaction="false"> -->
                                            <div class="banner-main-slider col-8 w-100">
                                                    @foreach ($sliders as $key => $slider)
                                                        <!-- <swiper-slide> -->
                                                    <img class="sliderBannerPrimary d-block rounded-xl mw-100 w-100 img-fit h-280px"
                                                    src="{{ $slider ? my_asset($slider->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                                    alt="{{ env('APP_NAME') }} promo"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                                    
                                                    <!-- </swiper-slide> -->
                                                    @endforeach
                                            </div> 
                                        <!-- </swiper-container> -->
                                @endif
                               <!-- One day product -->
                    @php $oneday_product = get_todays_product(); @endphp
                    <div class="payMoneyAdsProduct col-4  d-flex flex-column align-items-center justify-content-center">
                        <div class="productOneDay d-flex align-items-center justify-content-between">
                            <h2 class="font-weight-bold fs-20">Sản phẩm trong ngày</h2>
                            <span class="font-weight-bold inline-block fs-16">    
                                {{ date('H:i d/m/Y', strtotime($oneday_product->created_at)) }}
                            </span>
                        </div>
                        <div class="product__oneday-card row d-flex align-items-center">
                            <div class="col-6">
                                <img class="mw-100 img-fit h-140px"  src="{{ $oneday_product->thumbnail != null ? my_asset($oneday_product->thumbnail->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                alt="{{ $oneday_product->getTranslation('name') }}" title="{{ $oneday_product->getTranslation('name') }}"
                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';" alt="" s>
                            </div>
                            <div class="col-6 px-0 d-flex flex-column" style="gap:10px;">
                                <div class="product__oneday-price d-flex align-items-center">
                                    <span class="fw-700 fs-20 text-primary">
                                        {{ number_format( $oneday_product->unit_price,0, ',', '.') ; }}
                                    </span>
                                    <span
                                        class="fw-500 text-gray-dark fs-11 ml-2 text-decoration-line-through">
                                        {{ home_discounted_base_price($oneday_product) }}
                                </span>
                                </div>

                                @if (avg_start_rating($oneday_product->id) > 0)
                                <div class="oneday_product__onday-rate d-flex align-items-center justify-content-between">
                                    <div class="start__count d-flex align-items-center ">
                                        <img class="icon-xs" src="{{ static_asset('assets/img/star.svg') }}" alt="">
                                        <span class="fs-12 fw-700">{{  avg_start_rating($oneday_product->id) }}</span>
                                    </div>
                                    <span class="fs-12 fw-500 ml-2"> {{ count_review($oneday_product->id) }} đánh giá</span>
                                        đánh giá</span>
                                </div>
                            @else
                                <div class="product-rating my-1 d-flex align-items-center mb-2">
                                    <span class="text-danger">Chưa có đánh giá</span>
                                </div>
                            @endif

                                <div class="product__oneday-name">
                                    <h2 class="fs-15 fw-500 ">
                                        <a href="{{ route('product', $oneday_product->slug) }}"
                                            class="text-reset">{{ $oneday_product->getTranslation('name') }}</a>
                                    </h2>
                                  
                                </div>

                                <a @if (in_array($oneday_product->id, $cart_added)) active @endif" href="javascript:void(0)"
                                    @if (Auth::check()) onclick="showAddToCartModal({{ $oneday_product->id }})" @else onclick="showLoginModal()" @endif>
                                <button class="btn__add-to-cart fs-12 btn w-100 p-2" style="white-space:nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="icon-sm mr-1">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                    </svg>
                                    Thêm vào giỏ hàng
                                </button>
                            </a>
                            </div>
                        </div>
                    </div>
                            
                        </div>
                    </div>
                </div>

                <div class="categoryBodyContainer text-center">
            <h2 class="categoryBodyContainer--title font-weight-bold">Danh mục của chúng tôi</h2>
            <div class="aiz-category-menu bg-white rounded-0 " id="category-sidebar" >
                    <ul class="category-section d-flex justify-content-center">
                        @foreach (get_level_zero_categories()->take(10) as $key => $category)
                            @php
                                $category_name = $category->getTranslation('name');
                            @endphp
                            <li class="category-nav-element " data-id="{{ $category->id }}">
                                <a href="{{ route('products.category', $category->slug) }}"
                                    class="category-section--child text-center d-flex flex-column align-items-center ">
                                    <img class="category-child--image lazyload" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                        data-src="{{ isset($category->catIcon->file_name) ? my_asset($category->catIcon->file_name) : static_asset('assets/img/placeholder.jpg') }}" width="16" alt="{{ $category_name }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                    <span class="cat-name has-transition">{{ $category_name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
            </div>
        </div>
                        
            <div class="bannerBody">
                    <div class="smallBannerAds row d-flex flex-nowrap justify-content-between">
                        <div class="bannerContainerChild col-4">
                            <img class="imageBannerAds w-100 img-fit" src="{{ static_asset('assets/img/bannerqcbody/banner_qc.webp')}}" alt="">
                            <div class="payMoneyAds">
                                <span class="text-[10px]">Quảng cáo</span>
                            </div>
                        </div>
                        <div class="bannerContainerChild col-4">
                            <img class="imageBannerAds w-100 img-fit" src="{{ static_asset('assets/img/bannerqcbody/banner_qc.webp')}}" alt="">
                            <div class="payMoneyAds">
                                <span class="text-[10px]">Quảng cáo</span>
                            </div>
                        </div>
                        <div class="bannerContainerChild col-4">
                            <img class="imageBannerAds w-100 img-fit" src="{{ static_asset('assets/img/bannerqcbody/banner_qc.webp')}}" alt="">
                            <div class="payMoneyAds">
                                <span class="text-[10px]">Quảng cáo</span>
                            </div>
                        </div>
                    </div>
            </div>
            
              <!-- Featured Products -->
              <div class="productContainer my-5">
              <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
        <!-- Title -->
        <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
            <span class="">Sản phẩm bán chạy nhất</span>
        </h3>
        <!-- Links -->
        <div class="d-flex px-3">
            <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary"
                href="{{ route('categories.all') }}">Xem tất cả <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon-xs">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                  </svg>
                  </a>
        </div>
    </div>
        
        <div class="productList ">
            <div class="row featured-product-list-product productListSlide product-sale-home-page ">
                @foreach (get_all_products() as $product)
                    @php
                        $product_url = route('product', $product->slug);
                    @endphp
                    <div class="featured__product-card product-hover position-relative  p-md-3 p-2   col-lg-2 col-md-3 col-6 d-flex flex-column  justify-content-between"
                        style="gap:15px">
                        @if (discount_in_percentage($product) > 0)
                            <div class="product__badge position-absolute start-0 translate-middle rounded px-2"
                                style="top: 10px; left: 10px;">
                                <span class="fw-500 text-light">-{{ discount_in_percentage($product) }}%</span>
                            </div>
                        @endif

                        <img class="lazyload mx-auto img-fit has-transition h-150px"
                            src="{{ $product->thumbnail != null ? my_asset($product->thumbnail->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                            alt="{{ $product->getTranslation('name') }}" title="{{ $product->getTranslation('name') }}"
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                        <div class="product__card-content d-flex flex-column">
                            <a href="{{ $product_url }}" class="product__card-title text-dark">
                                <h2 class="fs-14 fw-600 text-ellipsis-2">{{ $product->getTranslation('name') }}</h2>
                            </a>
                            @if (avg_start_rating($product->id) > 0)
                                <div class="product-rating my-1 d-flex align-items-center mb-2">
                                    <div class="star-icons d-flex align-items-center">
                                        <img width="20px" src="{{ static_asset('assets/img/star.svg') }}"
                                            alt="Star">
                                    </div>
                                    <div class="rating-count ml-1 text-sm font-semibold">
                                        {{ avg_start_rating($product->id) }}
                                    </div>
                                    <div class="numberReviews ml-3  flex items-center gap-1 d-flex align-items-center"
                                        style="gap:5px">
                                        <img width="20px" src="{{ static_asset('assets/img/chat.svg') }}"
                                            alt=""><span class="count__rate"> {{ count_review($product->id) }}
                                            đánh
                                            giá</span>
                                    </div>

                                </div>
                            @else
                                <div class="product-rating my-1 d-flex align-items-center mb-2">
                                    <span class="text-danger">Chưa có đánh giá</span>
                                </div>
                            @endif

                            <div class="price-and-cart d-flex flex-column justify-content-between mb-2">
                                <div class="price-info text-gray-600 d-flex align-items-center gap-3 d-flex "
                                    style="gap:10px;">
                                    {{-- <span class="new-price text-red-600 font-bold text-[24px] inline-block">400.000đ</span>
                                    <span class="old-price text-decoration-line-through">499.000đ</span> --}}

                                    @if (home_base_price($product) != home_discounted_base_price($product))
                                        <div class="disc-amount has-transition">
                                            <del
                                                class="old-price text-decoration-line-through">{{$product->unit_price}}</del>
                                        </div>
                                    @endif
                                    <!-- price -->
                                    <div class="">
                                        <span
                                            class="new-price text-red-600 font-bold  inline-block">{{ home_discounted_base_price($product) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="cartContainerandOp d-flex align-items-center justify-content-between ">
                                <a @if (in_array($product->id, $cart_added)) active @endif" href="javascript:void(0)"
                                    @if (Auth::check()) onclick="showAddToCartModal({{ $product->id }})" @else onclick="showLoginModal()" @endif
                                    class="cart-icon btn__add-to-cart  h-40px d-flex justify-content-center align-items-center">
                                    <img src="{{ static_asset('assets/img/shopping-cart.svg') }}" alt="Shopping Cart">
                                </a>
                                <!-- add to cart -->

                                <div class="wishlistContainer d-flex  align-items-center " style="gap:10px;">
                                    <div class="wishlist-icon-container flex ">
                                        <a href="javascript:void(0)" class="hov-svg-white"
                                            onclick="addToWishList({{ $product->id }})" data-toggle="tooltip"
                                            data-title="Thêm vào mục ưa thích" data-placement="left">
                                            <img width="20px" class="w-5 h-5 transition transform hover:scale-110"
                                                src="{{ static_asset('assets/img/heart 2.svg') }}" alt="Wishlist"
                                                style="cursor: pointer;">
                                        </a>
                                    </div>
                                    <div class="wishlist-icon-container flex">
                                        <a href="javascript:void(0)" data-toggle="tooltip"
                                            data-title="Thêm vào mục so sánh" data-placement="left"
                                            onclick="addToCompare({{ $product->id }})">
                                            <img width="20px" class=" transition transform hover:scale-110"
                                                src="{{ static_asset('assets/img/chart.svg') }}" alt="Compare"
                                                style="cursor: pointer;">
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- -------------end list product --}}
                <!-- Top Sellers -->
                @if (get_setting('vendor_system_activation') == 1)
                    @php
                        $best_selers = get_best_sellers(5);
                    @endphp
                    @if (count($best_selers) > 0)
                        <section class="mb-2 mb-md-3 mt-2 mt-md-3">
                            <div class="container">
                                <!-- Top Section -->
                                <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                                    <!-- Title -->
                                    <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                                        <span class="pb-3">{{ translate('Top Sellers') }}</span>
                                    </h3>
                                    <!-- Links -->
                                    <div class="d-flex">
                                        <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary"
                                            href="{{ route('sellers') }}">{{ translate('View All Sellers') }}</a>
                                    </div>
                                </div>
                                <!-- Sellers Section -->
                                <div class="aiz-carousel arrow-x-0 arrow-inactive-none" data-items="5" data-xxl-items="5"
                                    data-xl-items="4" data-lg-items="3.4" data-md-items="2.5" data-sm-items="2"
                                    data-xs-items="1.4" data-arrows="true" data-dots="false">
                                    @foreach ($best_selers as $key => $seller)
                                        @if ($seller->user != null)
                                            <div
                                                class="carousel-box h-100 position-relative text-center border-right border-top border-bottom @if ($key == 0) border-left @endif has-transition hov-animate-outline">
                                                <div class="position-relative px-3"
                                                    style="padding-top: 2rem; padding-bottom:2rem;">
                                                    <!-- Shop logo & Verification Status -->
                                                    <div class="position-relative mx-auto size-100px size-md-120px">
                                                        <a href="{{ route('shop.visit', $seller->slug) }}"
                                                            class="d-flex mx-auto justify-content-center align-item-center size-100px size-md-120px border overflow-hidden hov-scale-img"
                                                            tabindex="0"
                                                            style="border: 1px solid #e5e5e5; border-radius: 50%; box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.06);">
                                                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                                                data-src="{{ uploaded_asset($seller->logo) }}"
                                                                alt="{{ $seller->name }}"
                                                                class="img-fit lazyload has-transition"
                                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                                        </a>
                                                        <div
                                                            class="absolute-top-right z-1 mr-md-2 mt-1 rounded-content bg-white">
                                                            @if ($seller->verification_status == 1)
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24.001"
                                                                    height="24" viewBox="0 0 24.001 24">
                                                                    <g id="Group_25929" data-name="Group 25929"
                                                                        transform="translate(-480 -345)">
                                                                        <circle id="Ellipse_637" data-name="Ellipse 637"
                                                                            cx="12" cy="12" r="12"
                                                                            transform="translate(480 345)"
                                                                            fill="#fff" />
                                                                        <g id="Group_25927" data-name="Group 25927"
                                                                            transform="translate(480 345)">
                                                                            <path id="Union_5" data-name="Union 5"
                                                                                d="M0,12A12,12,0,1,1,12,24,12,12,0,0,1,0,12Zm1.2,0A10.8,10.8,0,1,0,12,1.2,10.812,10.812,0,0,0,1.2,12Zm1.2,0A9.6,9.6,0,1,1,12,21.6,9.611,9.611,0,0,1,2.4,12Zm5.115-1.244a1.083,1.083,0,0,0,0,1.529l3.059,3.059a1.081,1.081,0,0,0,1.529,0l5.1-5.1a1.084,1.084,0,0,0,0-1.53,1.081,1.081,0,0,0-1.529,0L11.339,13.05,9.045,10.756a1.082,1.082,0,0,0-1.53,0Z"
                                                                                transform="translate(0 0)"
                                                                                fill="#3490f3" />
                                                                        </g>
                                                                    </g>
                                                                </svg>
                                                            @else
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24.001"
                                                                    height="24" viewBox="0 0 24.001 24">
                                                                    <g id="Group_25929" data-name="Group 25929"
                                                                        transform="translate(-480 -345)">
                                                                        <circle id="Ellipse_637" data-name="Ellipse 637"
                                                                            cx="12" cy="12" r="12"
                                                                            transform="translate(480 345)"
                                                                            fill="#fff" />
                                                                        <g id="Group_25927" data-name="Group 25927"
                                                                            transform="translate(480 345)">
                                                                            <path id="Union_5" data-name="Union 5"
                                                                                d="M0,12A12,12,0,1,1,12,24,12,12,0,0,1,0,12Zm1.2,0A10.8,10.8,0,1,0,12,1.2,10.812,10.812,0,0,0,1.2,12Zm1.2,0A9.6,9.6,0,1,1,12,21.6,9.611,9.611,0,0,1,2.4,12Zm5.115-1.244a1.083,1.083,0,0,0,0,1.529l3.059,3.059a1.081,1.081,0,0,0,1.529,0l5.1-5.1a1.084,1.084,0,0,0,0-1.53,1.081,1.081,0,0,0-1.529,0L11.339,13.05,9.045,10.756a1.082,1.082,0,0,0-1.53,0Z"
                                                                                transform="translate(0 0)"
                                                                                fill="red" />
                                                                        </g>
                                                                    </g>
                                                                </svg>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <!-- Shop name -->
                                                    <h2
                                                        class="fs-14 fw-700 text-dark text-truncate-2 h-40px mt-3 mt-md-4 mb-0 mb-md-3">
                                                        <a href="{{ route('shop.visit', $seller->slug) }}"
                                                            class="text-reset hov-text-primary"
                                                            tabindex="0">{{ $seller->name }}</a>
                                                    </h2>
                                                    <!-- Shop Rating -->
                                                    <div class="rating rating-mr-1 text-dark mb-3">
                                                        {{ renderStarRating($seller->rating) }}
                                                        <span class="opacity-60 fs-14">({{ $seller->num_of_reviews }}
                                                            {{ translate('Reviews') }})</span>
                                                    </div>
                                                    <!-- Visit Button -->
                                                    <a href="{{ route('shop.visit', $seller->slug) }}"
                                                        class="btn-visit">
                                                        <span class="circle" aria-hidden="true">
                                                            <span class="icon arrow"></span>
                                                        </span>
                                                        <span class="button-text">{{ translate('Visit Store') }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </section>
                    @endif
                @endif

                
            </div>
        </div>
     <!-- Banner Section 2 -->
     @php $homeBanner2Images = get_setting('home_banner2_images', null, $lang);   @endphp
    @if ($homeBanner2Images != null)
        <div class="mb-2 mb-md-3 mt-2 mt-md-3">
            <div class="container">
                @php
                    $banner_2_imags = json_decode($homeBanner2Images);
                    $data_md = count($banner_2_imags) >= 2 ? 2 : 1;
                    $home_banner2_links = get_setting('home_banner2_links', null, $lang);
                @endphp
                <div class="aiz-carousel gutters-16 overflow-hidden arrow-inactive-none arrow-dark arrow-x-15"
                    data-items="{{ count($banner_2_imags) }}" data-xxl-items="{{ count($banner_2_imags) }}"
                    data-xl-items="{{ count($banner_2_imags) }}" data-lg-items="{{ $data_md }}"
                    data-md-items="{{ $data_md }}" data-sm-items="1" data-xs-items="1" data-arrows="true"
                    data-dots="false">
                    @foreach ($banner_2_imags as $key => $value)
                        <div class="carousel-box overflow-hidden hov-scale-img">
                            <a  href="{{ isset(json_decode($home_banner2_links, true)[$key]) ? json_decode($home_banner2_links, true)[$key] : '' }}"
                                class="d-block text-reset overflow-hidden position-relative">
                                <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                    data-src="{{ uploaded_asset($value) }}" alt="{{ env('APP_NAME') }} promo"
                                    class="img-fluid lazyload w-100 has-transition"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                <div class="adsTitle position-absolute">
                                    <span>Quảng cáo</span>
                                </div>
                                </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif


    
    </div>
    
            <div class="list__ads row">
                <div class="col-md-4 col-lg-3 col-6 position-relative mb-4">
                    <img class="img-fit w-100" style="border-radius:10px;" src="{{ static_asset('assets/img/BANNER DOC.jpg')}}" alt="">
                    <div class="ads__title p-1 bg-light position-absolute rounded-lg" style=" top:5px ;right:20px">
                        <span class="fs-12 fw-500 text-dark d-block">Quảng cáo</span>
                    </div>
                </div>
                
                <div class="col-md-4 col-lg-3 col-6 position-relative mb-4">
                    <img class="img-fit w-100" style="border-radius:10px;" src="{{ static_asset('assets/img/BANNER DOC.jpg')}}" alt="">
                    <div class="ads__title p-1 bg-light position-absolute rounded-lg" style=" top:5px ;right:20px">
                        <span class="fs-12 fw-500 text-dark d-block">Quảng cáo</span>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3 col-6 position-relative mb-4">
                    <img class="img-fit w-100" style="border-radius:10px;" src="{{ static_asset('assets/img/BANNER DOC.jpg')}}" alt="">
                    <div class="ads__title p-1 bg-light position-absolute rounded-lg" style=" top:5px ;right:20px">
                        <span class="fs-12 fw-500 text-dark d-block">Quảng cáo</span>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3 col-6 position-relative mb-4">
                    <img class="img-fit w-100" style="border-radius:10px;" src="{{ static_asset('assets/img/BANNER DOC.jpg')}}" alt="">
                    <div class="ads__title p-1 bg-light position-absolute rounded-lg" style=" top:5px ;right:20px">
                        <span class="fs-12 fw-500 text-dark d-block">Quảng cáo</span>
                    </div>
                </div>
        </div>
     
<!-- list san pham section2 -->
<div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
        <!-- Title -->
        <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
            <span class="">Sản phẩm nổi bật</span>
        </h3>
        <!-- Links -->
        <div class="d-flex px-3">
            <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary"
                href="{{ route('categories.all') }}">Xem tất cả <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon-xs">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                  </svg>
                  </a>
        </div>
    </div>
    <div class="productList ">
            <div class="row featured-product-list-product productListSlide product-sale-home-page ">
                @foreach (get_all_products() as $product)
                    @php
                        $product_url = route('product', $product->slug);
                    @endphp
                    <div class="featured__product-card product-hover  position-relative  p-md-3 p-2   col-lg-2 col-md-3 col-6 d-flex flex-column  justify-content-between"
                        style="gap:15px">
                        @if (discount_in_percentage($product) > 0)
                            <div class="product__badge position-absolute start-0 translate-middle rounded px-2"
                                style="top: 10px; left: 10px;">
                                <span class="fw-500 text-light">-{{ discount_in_percentage($product) }}%</span>
                            </div>
                        @endif

                        <img class="lazyload mx-auto img-fit has-transition h-150px"
                            src="{{ $product->thumbnail != null ? my_asset($product->thumbnail->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                            alt="{{ $product->getTranslation('name') }}" title="{{ $product->getTranslation('name') }}"
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                        <div class="product__card-content d-flex flex-column">
                            <a href="{{ $product_url }}" class="product__card-title text-dark">
                                <h2 class="fs-14 fw-600 text-ellipsis-2">{{ $product->getTranslation('name') }}</h2>
                            </a>
                            @if (avg_start_rating($product->id) > 0)
                                <div class="product-rating my-1 d-flex align-items-center mb-2">
                                    <div class="star-icons d-flex align-items-center">
                                        <img width="20px" src="{{ static_asset('assets/img/star.svg') }}"
                                            alt="Star">
                                    </div>
                                    <div class="rating-count ml-1 text-sm font-semibold">
                                        {{ avg_start_rating($product->id) }}
                                    </div>
                                    <div class="numberReviews ml-3  flex items-center gap-1 d-flex align-items-center"
                                        style="gap:5px">
                                        <img width="20px" src="{{ static_asset('assets/img/chat.svg') }}"
                                            alt=""><span class="count__rate"> {{ count_review($product->id) }}
                                            đánh
                                            giá</span>
                                    </div>

                                </div>
                            @else
                                <div class="product-rating my-1 d-flex align-items-center mb-2">
                                    <span class="text-danger">Chưa có đánh giá</span>
                                </div>
                            @endif

                            <div class="price-and-cart d-flex flex-column justify-content-between mb-2">
                                <div class="price-info text-gray-600 d-flex align-items-center gap-3 d-flex "
                                    style="gap:10px;">
                                    {{-- <span class="new-price text-red-600 font-bold text-[24px] inline-block">400.000đ</span>
                                    <span class="old-price text-decoration-line-through">499.000đ</span> --}}

                                    @if (home_base_price($product) != home_discounted_base_price($product))
                                        <div class="disc-amount has-transition">
                                            <del
                                                class="old-price text-decoration-line-through">{{$product->unit_price}}</del>
                                        </div>
                                    @endif
                                    <!-- price -->
                                    <div class="">
                                        <span
                                            class="new-price text-red-600 font-bold  inline-block">{{ home_discounted_base_price($product) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="cartContainerandOp d-flex align-items-center justify-content-between ">
                                <a @if (in_array($product->id, $cart_added)) active @endif" href="javascript:void(0)"
                                    @if (Auth::check()) onclick="showAddToCartModal({{ $product->id }})" @else onclick="showLoginModal()" @endif
                                    class="cart-icon btn__add-to-cart  h-40px d-flex justify-content-center align-items-center">
                                    <img src="{{ static_asset('assets/img/shopping-cart.svg') }}" alt="Shopping Cart">
                                </a>
                                <!-- add to cart -->

                                <div class="wishlistContainer d-flex  align-items-center " style="gap:10px;">
                                    <div class="wishlist-icon-container flex ">
                                        <a href="javascript:void(0)" class="hov-svg-white"
                                            onclick="addToWishList({{ $product->id }})" data-toggle="tooltip"
                                            data-title="Thêm vào mục ưa thích" data-placement="left">
                                            <img width="20px" class="w-5 h-5 transition transform hover:scale-110"
                                                src="{{ static_asset('assets/img/heart 2.svg') }}" alt="Wishlist"
                                                style="cursor: pointer;">
                                        </a>
                                    </div>
                                    <div class="wishlist-icon-container flex">
                                        <a href="javascript:void(0)" data-toggle="tooltip"
                                            data-title="Thêm vào mục so sánh" data-placement="left"
                                            onclick="addToCompare({{ $product->id }})">
                                            <img width="20px" class=" transition transform hover:scale-110"
                                                src="{{ static_asset('assets/img/chart.svg') }}" alt="Compare"
                                                style="cursor: pointer;">
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- -------------end list product --}}
                <!-- Top Sellers -->
                @if (get_setting('vendor_system_activation') == 1)
                    @php
                        $best_selers = get_best_sellers(5);
                    @endphp
                    @if (count($best_selers) > 0)
                        <section class="mb-2 mb-md-3 mt-2 mt-md-3">
                            <div class="container">
                                <!-- Top Section -->
                                <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                                    <!-- Title -->
                                    <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                                        <span class="pb-3">{{ translate('Top Sellers') }}</span>
                                    </h3>
                                    <!-- Links -->
                                    <div class="d-flex">
                                        <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary"
                                            href="{{ route('sellers') }}">{{ translate('View All Sellers') }}</a>
                                    </div>
                                </div>
                                <!-- Sellers Section -->
                                <div class="aiz-carousel arrow-x-0 arrow-inactive-none" data-items="5" data-xxl-items="5"
                                    data-xl-items="4" data-lg-items="3.4" data-md-items="2.5" data-sm-items="2"
                                    data-xs-items="1.4" data-arrows="true" data-dots="false">
                                    @foreach ($best_selers as $key => $seller)
                                        @if ($seller->user != null)
                                            <div
                                                class="carousel-box h-100 position-relative text-center border-right border-top border-bottom @if ($key == 0) border-left @endif has-transition hov-animate-outline">
                                                <div class="position-relative px-3"
                                                    style="padding-top: 2rem; padding-bottom:2rem;">
                                                    <!-- Shop logo & Verification Status -->
                                                    <div class="position-relative mx-auto size-100px size-md-120px">
                                                        <a href="{{ route('shop.visit', $seller->slug) }}"
                                                            class="d-flex mx-auto justify-content-center align-item-center size-100px size-md-120px border overflow-hidden hov-scale-img"
                                                            tabindex="0"
                                                            style="border: 1px solid #e5e5e5; border-radius: 50%; box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.06);">
                                                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                                                data-src="{{ uploaded_asset($seller->logo) }}"
                                                                alt="{{ $seller->name }}"
                                                                class="img-fit lazyload has-transition"
                                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                                        </a>
                                                        <div
                                                            class="absolute-top-right z-1 mr-md-2 mt-1 rounded-content bg-white">
                                                            @if ($seller->verification_status == 1)
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24.001"
                                                                    height="24" viewBox="0 0 24.001 24">
                                                                    <g id="Group_25929" data-name="Group 25929"
                                                                        transform="translate(-480 -345)">
                                                                        <circle id="Ellipse_637" data-name="Ellipse 637"
                                                                            cx="12" cy="12" r="12"
                                                                            transform="translate(480 345)"
                                                                            fill="#fff" />
                                                                        <g id="Group_25927" data-name="Group 25927"
                                                                            transform="translate(480 345)">
                                                                            <path id="Union_5" data-name="Union 5"
                                                                                d="M0,12A12,12,0,1,1,12,24,12,12,0,0,1,0,12Zm1.2,0A10.8,10.8,0,1,0,12,1.2,10.812,10.812,0,0,0,1.2,12Zm1.2,0A9.6,9.6,0,1,1,12,21.6,9.611,9.611,0,0,1,2.4,12Zm5.115-1.244a1.083,1.083,0,0,0,0,1.529l3.059,3.059a1.081,1.081,0,0,0,1.529,0l5.1-5.1a1.084,1.084,0,0,0,0-1.53,1.081,1.081,0,0,0-1.529,0L11.339,13.05,9.045,10.756a1.082,1.082,0,0,0-1.53,0Z"
                                                                                transform="translate(0 0)"
                                                                                fill="#3490f3" />
                                                                        </g>
                                                                    </g>
                                                                </svg>
                                                            @else
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24.001"
                                                                    height="24" viewBox="0 0 24.001 24">
                                                                    <g id="Group_25929" data-name="Group 25929"
                                                                        transform="translate(-480 -345)">
                                                                        <circle id="Ellipse_637" data-name="Ellipse 637"
                                                                            cx="12" cy="12" r="12"
                                                                            transform="translate(480 345)"
                                                                            fill="#fff" />
                                                                        <g id="Group_25927" data-name="Group 25927"
                                                                            transform="translate(480 345)">
                                                                            <path id="Union_5" data-name="Union 5"
                                                                                d="M0,12A12,12,0,1,1,12,24,12,12,0,0,1,0,12Zm1.2,0A10.8,10.8,0,1,0,12,1.2,10.812,10.812,0,0,0,1.2,12Zm1.2,0A9.6,9.6,0,1,1,12,21.6,9.611,9.611,0,0,1,2.4,12Zm5.115-1.244a1.083,1.083,0,0,0,0,1.529l3.059,3.059a1.081,1.081,0,0,0,1.529,0l5.1-5.1a1.084,1.084,0,0,0,0-1.53,1.081,1.081,0,0,0-1.529,0L11.339,13.05,9.045,10.756a1.082,1.082,0,0,0-1.53,0Z"
                                                                                transform="translate(0 0)"
                                                                                fill="red" />
                                                                        </g>
                                                                    </g>
                                                                </svg>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <!-- Shop name -->
                                                    <h2
                                                        class="fs-14 fw-700 text-dark text-truncate-2 h-40px mt-3 mt-md-4 mb-0 mb-md-3">
                                                        <a href="{{ route('shop.visit', $seller->slug) }}"
                                                            class="text-reset hov-text-primary"
                                                            tabindex="0">{{ $seller->name }}</a>
                                                    </h2>
                                                    <!-- Shop Rating -->
                                                    <div class="rating rating-mr-1 text-dark mb-3">
                                                        {{ renderStarRating($seller->rating) }}
                                                        <span class="opacity-60 fs-14">({{ $seller->num_of_reviews }}
                                                            {{ translate('Reviews') }})</span>
                                                    </div>
                                                    <!-- Visit Button -->
                                                    <a href="{{ route('shop.visit', $seller->slug) }}"
                                                        class="btn-visit">
                                                        <span class="circle" aria-hidden="true">
                                                            <span class="icon arrow"></span>
                                                        </span>
                                                        <span class="button-text">{{ translate('Visit Store') }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </section>
                    @endif
                @endif

               
            </div>
        </div>


        <div class="bannerBody">
                    <div class="smallBannerAds row d-flex flex-nowrap justify-content-between">
                        <div class="bannerContainerChild col-4">
                            <img class="imageBannerAds w-100 img-fit" src="{{ static_asset('assets/img/bannerBody/sale 1.png')}}" alt="">
                            <div class="payMoneyAds">
                                <span class="text-[10px]">Quảng cáo</span>
                            </div>
                        </div>
                        <div class="bannerContainerChild col-4">
                            <img class="imageBannerAds w-100 img-fit" src="{{ static_asset('assets/img/bannerBody/sale 2.png')}}" alt="">
                            <div class="payMoneyAds">
                                <span class="text-[10px]">Quảng cáo</span>
                            </div>
                        </div>
                        <div class="bannerContainerChild col-4">
                            <img class="imageBannerAds w-100 img-fit" src="{{ static_asset('assets/img/bannerBody/sale 5.png')}}" alt="">
                            <div class="payMoneyAds">
                                <span class="text-[10px]">Quảng cáo</span>
                            </div>
                        </div>
                    </div>
            </div>


            <div class="productList ">
                <div class="row featured-product-list-product productListSlide product-sale-home-page ">
                @foreach (get_all_products() as $product)
                    @php
                        $product_url = route('product', $product->slug);
                    @endphp
                    <div class="featured__product-card product-hover position-relative  p-md-3 p-2   col-lg-2 col-md-3 col-6 d-flex flex-column justify-content-between"
                        style="gap:15px">
                        @if (discount_in_percentage($product) > 0)
                            <div class="product__badge position-absolute start-0 translate-middle rounded px-2"
                                style="top: 10px; left: 10px;">
                                <span class="fw-500 text-light">-{{ discount_in_percentage($product) }}%</span>
                            </div>
                        @endif

                        <img class="lazyload mx-auto img-fit has-transition h-150px"
                            src="{{ $product->thumbnail != null ? my_asset($product->thumbnail->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                            alt="{{ $product->getTranslation('name') }}" title="{{ $product->getTranslation('name') }}"
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                        <div class="product__card-content d-flex flex-column">
                            <a href="{{ $product_url }}" class="product__card-title text-dark">
                                <h2 class="fs-14 fw-600 text-ellipsis-2">{{ $product->getTranslation('name') }}</h2>
                            </a>
                            @if (avg_start_rating($product->id) > 0)
                                <div class="product-rating my-1 d-flex align-items-center mb-2">
                                    <div class="star-icons d-flex align-items-center">
                                        <img width="20px" src="{{ static_asset('assets/img/star.svg') }}"
                                            alt="Star">
                                    </div>
                                    <div class="rating-count ml-1 text-sm font-semibold">
                                        {{ avg_start_rating($product->id) }}
                                    </div>
                                    <div class="numberReviews ml-3  flex items-center gap-1 d-flex align-items-center"
                                        style="gap:5px">
                                        <img width="20px" src="{{ static_asset('assets/img/chat.svg') }}"
                                            alt=""><span class="count__rate"> {{ count_review($product->id) }}
                                            đánh
                                            giá</span>
                                    </div>

                                </div>
                            @else
                                <div class="product-rating my-1 d-flex align-items-center mb-2">
                                    <span class="text-danger">Chưa có đánh giá</span>
                                </div>
                            @endif

                            <div class="price-and-cart d-flex flex-column justify-content-between mb-2">
                                <div class="price-info text-gray-600 d-flex align-items-center gap-3 d-flex "
                                    style="gap:10px;">
                                    {{-- <span class="new-price text-red-600 font-bold text-[24px] inline-block">400.000đ</span>
                                    <span class="old-price text-decoration-line-through">499.000đ</span> --}}

                                    @if (home_base_price($product) != home_discounted_base_price($product))
                                        <div class="disc-amount has-transition">
                                            <del
                                                class="old-price text-decoration-line-through">{{$product->unit_price}}</del>
                                        </div>
                                    @endif
                                    <!-- price -->
                                    <div class="">
                                        <span
                                            class="new-price text-red-600 font-bold  inline-block">{{ home_discounted_base_price($product) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="cartContainerandOp d-flex align-items-center justify-content-between ">
                                <a @if (in_array($product->id, $cart_added)) active @endif" href="javascript:void(0)"
                                    @if (Auth::check()) onclick="showAddToCartModal({{ $product->id }})" @else onclick="showLoginModal()" @endif
                                    class="cart-icon btn__add-to-cart  h-40px d-flex justify-content-center align-items-center">
                                    <img src="{{ static_asset('assets/img/shopping-cart.svg') }}" alt="Shopping Cart">
                                </a>
                                <!-- add to cart -->

                                <div class="wishlistContainer d-flex  align-items-center " style="gap:10px;">
                                    <div class="wishlist-icon-container flex ">
                                        <a href="javascript:void(0)" class="hov-svg-white"
                                            onclick="addToWishList({{ $product->id }})" data-toggle="tooltip"
                                            data-title="Thêm vào mục ưa thích" data-placement="left">
                                            <img width="20px" class="w-5 h-5 transition transform hover:scale-110"
                                                src="{{ static_asset('assets/img/heart 2.svg') }}" alt="Wishlist"
                                                style="cursor: pointer;">
                                        </a>
                                    </div>
                                    <div class="wishlist-icon-container flex">
                                        <a href="javascript:void(0)" data-toggle="tooltip"
                                            data-title="Thêm vào mục so sánh" data-placement="left"
                                            onclick="addToCompare({{ $product->id }})">
                                            <img width="20px" class=" transition transform hover:scale-110"
                                                src="{{ static_asset('assets/img/chart.svg') }}" alt="Compare"
                                                style="cursor: pointer;">
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- -------------end list product --}}
                <!-- Top Sellers -->
                @if (get_setting('vendor_system_activation') == 1)
                    @php
                        $best_selers = get_best_sellers(5);
                    @endphp
                    @if (count($best_selers) > 0)
                        <section class="mb-2 mb-md-3 mt-2 mt-md-3">
                            <div class="container">
                                <!-- Top Section -->
                                <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                                    <!-- Title -->
                                    <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                                        <span class="pb-3">{{ translate('Top Sellers') }}</span>
                                    </h3>
                                    <!-- Links -->
                                    <div class="d-flex">
                                        <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary"
                                            href="{{ route('sellers') }}">{{ translate('View All Sellers') }}</a>
                                    </div>
                                </div>
                                <!-- Sellers Section -->
                                <div class="aiz-carousel arrow-x-0 arrow-inactive-none" data-items="5" data-xxl-items="5"
                                    data-xl-items="4" data-lg-items="3.4" data-md-items="2.5" data-sm-items="2"
                                    data-xs-items="1.4" data-arrows="true" data-dots="false">
                                    @foreach ($best_selers as $key => $seller)
                                        @if ($seller->user != null)
                                            <div
                                                class="carousel-box h-100 position-relative text-center border-right border-top border-bottom @if ($key == 0) border-left @endif has-transition hov-animate-outline">
                                                <div class="position-relative px-3"
                                                    style="padding-top: 2rem; padding-bottom:2rem;">
                                                    <!-- Shop logo & Verification Status -->
                                                    <div class="position-relative mx-auto size-100px size-md-120px">
                                                        <a href="{{ route('shop.visit', $seller->slug) }}"
                                                            class="d-flex mx-auto justify-content-center align-item-center size-100px size-md-120px border overflow-hidden hov-scale-img"
                                                            tabindex="0"
                                                            style="border: 1px solid #e5e5e5; border-radius: 50%; box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.06);">
                                                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                                                data-src="{{ uploaded_asset($seller->logo) }}"
                                                                alt="{{ $seller->name }}"
                                                                class="img-fit lazyload has-transition"
                                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                                        </a>
                                                        <div
                                                            class="absolute-top-right z-1 mr-md-2 mt-1 rounded-content bg-white">
                                                            @if ($seller->verification_status == 1)
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24.001"
                                                                    height="24" viewBox="0 0 24.001 24">
                                                                    <g id="Group_25929" data-name="Group 25929"
                                                                        transform="translate(-480 -345)">
                                                                        <circle id="Ellipse_637" data-name="Ellipse 637"
                                                                            cx="12" cy="12" r="12"
                                                                            transform="translate(480 345)"
                                                                            fill="#fff" />
                                                                        <g id="Group_25927" data-name="Group 25927"
                                                                            transform="translate(480 345)">
                                                                            <path id="Union_5" data-name="Union 5"
                                                                                d="M0,12A12,12,0,1,1,12,24,12,12,0,0,1,0,12Zm1.2,0A10.8,10.8,0,1,0,12,1.2,10.812,10.812,0,0,0,1.2,12Zm1.2,0A9.6,9.6,0,1,1,12,21.6,9.611,9.611,0,0,1,2.4,12Zm5.115-1.244a1.083,1.083,0,0,0,0,1.529l3.059,3.059a1.081,1.081,0,0,0,1.529,0l5.1-5.1a1.084,1.084,0,0,0,0-1.53,1.081,1.081,0,0,0-1.529,0L11.339,13.05,9.045,10.756a1.082,1.082,0,0,0-1.53,0Z"
                                                                                transform="translate(0 0)"
                                                                                fill="#3490f3" />
                                                                        </g>
                                                                    </g>
                                                                </svg>
                                                            @else
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24.001"
                                                                    height="24" viewBox="0 0 24.001 24">
                                                                    <g id="Group_25929" data-name="Group 25929"
                                                                        transform="translate(-480 -345)">
                                                                        <circle id="Ellipse_637" data-name="Ellipse 637"
                                                                            cx="12" cy="12" r="12"
                                                                            transform="translate(480 345)"
                                                                            fill="#fff" />
                                                                        <g id="Group_25927" data-name="Group 25927"
                                                                            transform="translate(480 345)">
                                                                            <path id="Union_5" data-name="Union 5"
                                                                                d="M0,12A12,12,0,1,1,12,24,12,12,0,0,1,0,12Zm1.2,0A10.8,10.8,0,1,0,12,1.2,10.812,10.812,0,0,0,1.2,12Zm1.2,0A9.6,9.6,0,1,1,12,21.6,9.611,9.611,0,0,1,2.4,12Zm5.115-1.244a1.083,1.083,0,0,0,0,1.529l3.059,3.059a1.081,1.081,0,0,0,1.529,0l5.1-5.1a1.084,1.084,0,0,0,0-1.53,1.081,1.081,0,0,0-1.529,0L11.339,13.05,9.045,10.756a1.082,1.082,0,0,0-1.53,0Z"
                                                                                transform="translate(0 0)"
                                                                                fill="red" />
                                                                        </g>
                                                                    </g>
                                                                </svg>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <!-- Shop name -->
                                                    <h2
                                                        class="fs-14 fw-700 text-dark text-truncate-2 h-40px mt-3 mt-md-4 mb-0 mb-md-3">
                                                        <a href="{{ route('shop.visit', $seller->slug) }}"
                                                            class="text-reset hov-text-primary"
                                                            tabindex="0">{{ $seller->name }}</a>
                                                    </h2>
                                                    <!-- Shop Rating -->
                                                    <div class="rating rating-mr-1 text-dark mb-3">
                                                        {{ renderStarRating($seller->rating) }}
                                                        <span class="opacity-60 fs-14">({{ $seller->num_of_reviews }}
                                                            {{ translate('Reviews') }})</span>
                                                    </div>
                                                    <!-- Visit Button -->
                                                    <a href="{{ route('shop.visit', $seller->slug) }}"
                                                        class="btn-visit">
                                                        <span class="circle" aria-hidden="true">
                                                            <span class="icon arrow"></span>
                                                        </span>
                                                        <span class="button-text">{{ translate('Visit Store') }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </section>
                    @endif
                @endif

               
            </div>
        </div>
             <!-- Top Brands -->
             <!-- @if (get_setting('top_brands') != null)
                        @php
                            $top_brands = json_decode(get_setting('top_brands'));
                            $brands = get_brands($top_brands);
                        @endphp 
                    <swiper-container class="top-brand-container  pt-2" init="true" loop="true" autoplay="true">
                    @foreach ($brands as $brand)
                        
                            <swiper-slide class="pb-4">
                                <div class="col py-2  text-center  hov-scale-img has-transition hov-shadow-out z-1"
                                    style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;border-radius:15px;">
                                    <a href="{{ route('products.brand', $brand->slug) }}" class="d-block p-sm-2">
                                        <img src="{{ isset($brand->brandLogo->file_name) ? my_asset($brand->brandLogo->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                            class="lazyload h-80px h-md-50px  mx-auto has-transition p-2 mw-100"
                                            alt="{{ $brand->getTranslation('name') }}"
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                        <p class="text-center text-dark fs-11  fw-700">
                                            {{ $brand->getTranslation('name') }}
                                        </p>
                                    </a>
                                </div>
                            </swiper-slide>
                        @endforeach
                    </swiper-container>
                @endif -->

        </div>    
   
    <!-- Flash Deal -->
    <!-- @php
        $flash_deal = get_featured_flash_deal();
    @endphp
    
    @if ($flash_deal != null)
        <section class="mb-2 mb-md-3 mt-2 mt-md-3" id="flash_deal">
            <div class="container">
                Top Section
                <div class="d-flex flex-wrap mb-2 mb-md-3 align-items-baseline justify-content-between">
                    Title
                    <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                        <span class="d-inline-block">{{ translate('Flash Sale') }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="24" viewBox="0 0 16 24"
                            class="ml-3">
                            <path id="Path_28795" data-name="Path 28795"
                                d="M30.953,13.695a.474.474,0,0,0-.424-.25h-4.9l3.917-7.81a.423.423,0,0,0-.028-.428.477.477,0,0,0-.4-.207H21.588a.473.473,0,0,0-.429.263L15.041,18.151a.423.423,0,0,0,.034.423.478.478,0,0,0,.4.2h4.593l-2.229,9.683a.438.438,0,0,0,.259.5.489.489,0,0,0,.571-.127L30.9,14.164a.425.425,0,0,0,.054-.469Z"
                                transform="translate(-15 -5)" fill="#fcc201" />
                        </svg>
                    </h3>
                    Links
                    <div>
                        <div class="text-dark d-flex align-items-center mb-0">
                            <a href="{{ route('flash-deals') }}"
                                class="fs-10 fs-md-12 fw-700 text-reset has-transition opacity-60 hov-opacity-100 hov-text-primary animate-underline-primary mr-3">{{ translate('View All Flash Sale') }}</a>
                            <span class=" border-left border-soft-light border-width-2 pl-3">
                                <a href="{{ route('flash-deal-details', $flash_deal->slug) }}"
                                    class="fs-10 fs-md-12 fw-700 text-reset has-transition opacity-60 hov-opacity-100 hov-text-primary animate-underline-primary">{{ translate('View All Products from This Flash Sale') }}</a>
                            </span>
                        </div>
                    </div>
                </div>

                Countdown for small device
                <div class="bg-white mb-3 d-md-none">
                    <div class="aiz-count-down-circle" end-date="{{ date('Y/m/d H:i:s', $flash_deal->end_date) }}"></div>
                </div>

                <div class="row gutters-5 gutters-md-16">
                    Flash Deals Baner & Countdown
                    <div class="flash-deals-baner col-xxl-4 col-lg-5 col-6 h-200px h-md-400px h-lg-475px">
                        <div class="h-100 w-100 w-xl-auto"
                            style="background-image: url('{{ uploaded_asset($flash_deal->banner) }}'); background-size: cover; background-position: center center;">
                            <div class="py-5 px-md-3 px-xl-5 d-none d-md-block">
                                <div class="bg-white">
                                    <div class="aiz-count-down-circle"
                                        end-date="{{ date('Y/m/d H:i:s', $flash_deal->end_date) }}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    Flash Deals Products
                    <div class="col-xxl-8 col-lg-7 col-6">
                        @php
                            $flash_deal_products = get_flash_deal_products($flash_deal->id);
                        @endphp
                        <div class="aiz-carousel border-top @if (count($flash_deal_products) > 8) border-right @endif arrow-inactive-none arrow-x-0"
                            data-rows="2" data-items="5" data-xxl-items="5" data-xl-items="3.5" data-lg-items="3" data-md-items="2"
                            data-sm-items="2.5" data-xs-items="1.7" data-arrows="true" data-dots="false">
                            @foreach ($flash_deal_products as $key => $flash_deal_product)
                                <div class="carousel-box border-left border-bottom">
                                    @if ($flash_deal_product->product != null && $flash_deal_product->product->published != 0)
                                        @php
                                            $product_url = route('product', $flash_deal_product->product->slug);
                                            if ($flash_deal_product->product->auction_product == 1) {
                                                $product_url = route('auction-product', $flash_deal_product->product->slug);
                                            }
                                        @endphp
                                        <div
                                            class="h-100px h-md-200px h-lg-auto flash-deal-item position-relative text-center has-transition hov-shadow-out z-1">
                                            <a href="{{ $product_url }}"
                                                class="d-block py-md-3 overflow-hidden hov-scale-img"
                                                title="{{ $flash_deal_product->product->getTranslation('name') }}">
                                                Image
                                                <img src="{{ get_image($flash_deal_product->product->thumbnail) }}"
                                                    class="lazyload h-60px h-md-100px h-lg-140px mw-100 mx-auto has-transition"
                                                    alt="{{ $flash_deal_product->product->getTranslation('name') }}"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                 Price
                                                <div
                                                    class="fs-10 fs-md-14 mt-md-3 text-center h-md-48px has-transition overflow-hidden pt-md-4 flash-deal-price lh-1-5">
                                                    <span
                                                        class="d-block text-primary fw-700">{{ home_discounted_base_price($flash_deal_product->product) }}</span>
                                                    @if (home_base_price($flash_deal_product->product) != home_discounted_base_price($flash_deal_product->product))
                                                        <del
                                                            class="d-block fw-400 text-secondary">{{ home_base_price($flash_deal_product->product) }}</del>
                                                    @endif
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif -->

    <!-- Today's deal -->
    <div id="todays_deal"  class="mb-2 mb-md-3 mt-2 mt-md-3">

    </div>

    <!-- Featured Categories -->
    <!-- @if (count($featured_categories) > 0)
        <section class="mb-2 mb-md-3 mt-2 mt-md-3">
            <div class="container">
                <div class="bg-white">
                    Top Section
                    <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                        Title
                        <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                            <span class="">{{ translate('Featured Categories') }}</span>
                        </h3>
                        Links
                        <div class="d-flex">
                            <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary"
                                href="{{ route('categories.all') }}">{{ translate('View All Categories') }}</a>
                        </div>
                    </div>
                </div>
                Categories
                <div class="bg-white px-3">
                    <div class="row border-top border-right">
                        @foreach ($featured_categories->take(6) as $key => $category)
                        @php
                            $category_name = $category->getTranslation('name');
                        @endphp
                            <div class="col-xl-4 col-md-6 border-left border-bottom py-3 py-md-2rem">
                                <div class="d-sm-flex text-center text-sm-left">
                                    <div class="mb-3">
                                        <img src="{{ isset($category->bannerImage->file_name) ? my_asset($category->bannerImage->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                            class="lazyload w-150px h-auto mx-auto has-transition"
                                            alt="{{ $category->getTranslation('name') }}"
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                    </div>
                                    <div class="px-2 px-lg-4">
                                        <h6 class="text-dark mb-0 text-truncate-2">
                                            <a class="text-reset fw-700 fs-14 hov-text-primary"
                                                href="{{ route('products.category', $category->slug) }}"
                                                title="{{ $category_name }}">
                                                {{ $category_name }}
                                            </a>
                                        </h6>
                                        @foreach ($category->childrenCategories->take(5) as $key => $child_category)
                                            <p class="mb-0 mt-3">
                                                <a href="{{ route('products.category', $child_category->slug) }}" class="fs-13 fw-300 text-reset hov-text-primary animate-underline-primary">
                                                    {{ $child_category->getTranslation('name') }}
                                                </a>
                                            </p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif -->

    <!-- Banner section 1 -->
    <!-- @php $homeBanner1Images = get_setting('home_banner1_images', null, $lang);   @endphp
    @if ($homeBanner1Images != null)
        <div class="mb-2 mb-md-3 mt-2 mt-md-3">
            <div class="container">
                @php
                    $banner_1_imags = json_decode($homeBanner1Images);
                    $data_md = count($banner_1_imags) >= 2 ? 2 : 1;
                    $home_banner1_links = get_setting('home_banner1_links', null, $lang);
                @endphp
                <div class="w-100">
                    <div class="aiz-carousel gutters-16 overflow-hidden arrow-inactive-none arrow-dark arrow-x-15"
                        data-items="{{ count($banner_1_imags) }}" data-xxl-items="{{ count($banner_1_imags) }}"
                        data-xl-items="{{ count($banner_1_imags) }}" data-lg-items="{{ $data_md }}"
                        data-md-items="{{ $data_md }}" data-sm-items="1" data-xs-items="1" data-arrows="true"
                        data-dots="false">
                        @foreach ($banner_1_imags as $key => $value)
                            <div class="carousel-box overflow-hidden hov-scale-img">
                                <a href="{{ isset(json_decode($home_banner1_links, true)[$key]) ? json_decode($home_banner1_links, true)[$key] : '' }}"
                                    class="d-block text-reset overflow-hidden">
                                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                        data-src="{{ uploaded_asset($value) }}" alt="{{ env('APP_NAME') }} promo"
                                        class="img-fluid lazyload w-100 has-transition"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif -->


    <!-- Best Selling  -->
    <!-- <div id="section_best_selling">

    </div> -->

    <!-- New Products -->
    <!-- <div id="section_newest">

    </div> -->

    <!-- Banner Section 3 -->
    <!-- @php $homeBanner3Images = get_setting('home_banner3_images', null, $lang);   @endphp
    @if ($homeBanner3Images != null)
        <div class="mb-2 mb-md-3 mt-2 mt-md-3">
            <div class="container">
                @php
                    $banner_3_imags = json_decode($homeBanner3Images);
                    $data_md = count($banner_3_imags) >= 2 ? 2 : 1;
                    $home_banner3_links = get_setting('home_banner3_links', null, $lang);
                @endphp
                <div class="aiz-carousel gutters-16 overflow-hidden arrow-inactive-none arrow-dark arrow-x-15"
                    data-items="{{ count($banner_3_imags) }}" data-xxl-items="{{ count($banner_3_imags) }}"
                    data-xl-items="{{ count($banner_3_imags) }}" data-lg-items="{{ $data_md }}"
                    data-md-items="{{ $data_md }}" data-sm-items="1" data-xs-items="1" data-arrows="true"
                    data-dots="false">
                    @foreach ($banner_3_imags as $key => $value)
                        <div class="carousel-box overflow-hidden hov-scale-img">
                            <a href="{{ isset(json_decode($home_banner3_links, true)[$key]) ? json_decode($home_banner3_links, true)[$key] : '' }}"
                                class="d-block text-reset overflow-hidden">
                                <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                    data-src="{{ uploaded_asset($value) }}" alt="{{ env('APP_NAME') }} promo"
                                    class="img-fluid lazyload w-100 has-transition"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif -->

    <!-- Auction Product -->
    <!-- @if (addon_is_activated('auction'))
        <div id="auction_products">

        </div>
    @endif -->

    <!-- Cupon -->
    <!-- @if (get_setting('coupon_system') == 1)
        <div class="mb-2 mb-md-3 mt-2 mt-md-3"
            style="background-color: {{ get_setting('cupon_background_color', '#292933') }}">
            <div class="container">
                <div class="row py-5">
                    <div class="col-xl-8 text-center text-xl-left">
                        <div class="d-lg-flex">
                            <div class="mb-3 mb-lg-0">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="109.602" height="93.34" viewBox="0 0 109.602 93.34">
                                    <defs>
                                        <clipPath id="clip-pathcup">
                                            <path id="Union_10" data-name="Union 10" d="M12263,13778v-15h64v-41h12v56Z"
                                                transform="translate(-11966 -8442.865)" fill="none" stroke="#fff"
                                                stroke-width="2" />
                                        </clipPath>
                                    </defs>
                                    <g id="Group_24326" data-name="Group 24326"
                                        transform="translate(-274.201 -5254.611)">
                                        <g id="Mask_Group_23" data-name="Mask Group 23"
                                            transform="translate(-3652.459 1785.452) rotate(-45)"
                                            clip-path="url(#clip-pathcup)">
                                            <g id="Group_24322" data-name="Group 24322"
                                                transform="translate(207 18.136)">
                                                <g id="Subtraction_167" data-name="Subtraction 167"
                                                    transform="translate(-12177 -8458)" fill="none">
                                                    <path
                                                        d="M12335,13770h-56a8.009,8.009,0,0,1-8-8v-8a8,8,0,0,0,0-16v-8a8.009,8.009,0,0,1,8-8h56a8.009,8.009,0,0,1,8,8v8a8,8,0,0,0,0,16v8A8.009,8.009,0,0,1,12335,13770Z"
                                                        stroke="none" />
                                                    <path
                                                        d="M 12335.0009765625 13768.0009765625 C 12338.3095703125 13768.0009765625 12341.0009765625 13765.30859375 12341.0009765625 13762 L 12341.0009765625 13755.798828125 C 12336.4423828125 13754.8701171875 12333.0009765625 13750.8291015625 12333.0009765625 13746 C 12333.0009765625 13741.171875 12336.4423828125 13737.130859375 12341.0009765625 13736.201171875 L 12341.0009765625 13729.9990234375 C 12341.0009765625 13726.6904296875 12338.3095703125 13723.9990234375 12335.0009765625 13723.9990234375 L 12278.9990234375 13723.9990234375 C 12275.6904296875 13723.9990234375 12272.9990234375 13726.6904296875 12272.9990234375 13729.9990234375 L 12272.9990234375 13736.201171875 C 12277.5576171875 13737.1298828125 12280.9990234375 13741.1708984375 12280.9990234375 13746 C 12280.9990234375 13750.828125 12277.5576171875 13754.869140625 12272.9990234375 13755.798828125 L 12272.9990234375 13762 C 12272.9990234375 13765.30859375 12275.6904296875 13768.0009765625 12278.9990234375 13768.0009765625 L 12335.0009765625 13768.0009765625 M 12335.0009765625 13770.0009765625 L 12278.9990234375 13770.0009765625 C 12274.587890625 13770.0009765625 12270.9990234375 13766.412109375 12270.9990234375 13762 L 12270.9990234375 13754 C 12275.4111328125 13753.9990234375 12278.9990234375 13750.4111328125 12278.9990234375 13746 C 12278.9990234375 13741.5888671875 12275.41015625 13738 12270.9990234375 13738 L 12270.9990234375 13729.9990234375 C 12270.9990234375 13725.587890625 12274.587890625 13721.9990234375 12278.9990234375 13721.9990234375 L 12335.0009765625 13721.9990234375 C 12339.412109375 13721.9990234375 12343.0009765625 13725.587890625 12343.0009765625 13729.9990234375 L 12343.0009765625 13738 C 12338.5888671875 13738.0009765625 12335.0009765625 13741.5888671875 12335.0009765625 13746 C 12335.0009765625 13750.4111328125 12338.58984375 13754 12343.0009765625 13754 L 12343.0009765625 13762 C 12343.0009765625 13766.412109375 12339.412109375 13770.0009765625 12335.0009765625 13770.0009765625 Z"
                                                        stroke="none" fill="#fff" />
                                                </g>
                                            </g>
                                        </g>
                                        <g id="Group_24321" data-name="Group 24321"
                                            transform="translate(-3514.477 1653.317) rotate(-45)">
                                            <g id="Subtraction_167-2" data-name="Subtraction 167"
                                                transform="translate(-12177 -8458)" fill="none">
                                                <path
                                                    d="M12335,13770h-56a8.009,8.009,0,0,1-8-8v-8a8,8,0,0,0,0-16v-8a8.009,8.009,0,0,1,8-8h56a8.009,8.009,0,0,1,8,8v8a8,8,0,0,0,0,16v8A8.009,8.009,0,0,1,12335,13770Z"
                                                    stroke="none" />
                                                <path
                                                    d="M 12335.0009765625 13768.0009765625 C 12338.3095703125 13768.0009765625 12341.0009765625 13765.30859375 12341.0009765625 13762 L 12341.0009765625 13755.798828125 C 12336.4423828125 13754.8701171875 12333.0009765625 13750.8291015625 12333.0009765625 13746 C 12333.0009765625 13741.171875 12336.4423828125 13737.130859375 12341.0009765625 13736.201171875 L 12341.0009765625 13729.9990234375 C 12341.0009765625 13726.6904296875 12338.3095703125 13723.9990234375 12335.0009765625 13723.9990234375 L 12278.9990234375 13723.9990234375 C 12275.6904296875 13723.9990234375 12272.9990234375 13726.6904296875 12272.9990234375 13729.9990234375 L 12272.9990234375 13736.201171875 C 12277.5576171875 13737.1298828125 12280.9990234375 13741.1708984375 12280.9990234375 13746 C 12280.9990234375 13750.828125 12277.5576171875 13754.869140625 12272.9990234375 13755.798828125 L 12272.9990234375 13762 C 12272.9990234375 13765.30859375 12275.6904296875 13768.0009765625 12278.9990234375 13768.0009765625 L 12335.0009765625 13768.0009765625 M 12335.0009765625 13770.0009765625 L 12278.9990234375 13770.0009765625 C 12274.587890625 13770.0009765625 12270.9990234375 13766.412109375 12270.9990234375 13762 L 12270.9990234375 13754 C 12275.4111328125 13753.9990234375 12278.9990234375 13750.4111328125 12278.9990234375 13746 C 12278.9990234375 13741.5888671875 12275.41015625 13738 12270.9990234375 13738 L 12270.9990234375 13729.9990234375 C 12270.9990234375 13725.587890625 12274.587890625 13721.9990234375 12278.9990234375 13721.9990234375 L 12335.0009765625 13721.9990234375 C 12339.412109375 13721.9990234375 12343.0009765625 13725.587890625 12343.0009765625 13729.9990234375 L 12343.0009765625 13738 C 12338.5888671875 13738.0009765625 12335.0009765625 13741.5888671875 12335.0009765625 13746 C 12335.0009765625 13750.4111328125 12338.58984375 13754 12343.0009765625 13754 L 12343.0009765625 13762 C 12343.0009765625 13766.412109375 12339.412109375 13770.0009765625 12335.0009765625 13770.0009765625 Z"
                                                    stroke="none" fill="#fff" />
                                            </g>
                                            <g id="Group_24325" data-name="Group 24325">
                                                <rect id="Rectangle_18578" data-name="Rectangle 18578" width="8"
                                                    height="2" transform="translate(120 5287)" fill="#fff" />
                                                <rect id="Rectangle_18579" data-name="Rectangle 18579" width="8"
                                                    height="2" transform="translate(132 5287)" fill="#fff" />
                                                <rect id="Rectangle_18581" data-name="Rectangle 18581" width="8"
                                                    height="2" transform="translate(144 5287)" fill="#fff" />
                                                <rect id="Rectangle_18580" data-name="Rectangle 18580" width="8"
                                                    height="2" transform="translate(108 5287)" fill="#fff" />
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <div class="ml-lg-3">
                                <h5 class="fs-36 fw-400 text-white mb-3">{{ translate(get_setting('cupon_title')) }}</h5>
                                <h5 class="fs-20 fw-400 text-gray">{{ translate(get_setting('cupon_subtitle')) }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 text-center text-xl-right mt-4">
                        <a href="{{ route('coupons.all') }}"
                            class="btn text-white hov-bg-white hov-text-dark border border-width-2 fs-16 px-4"
                            style="border-radius: 28px;background: rgba(255, 255, 255, 0.2);box-shadow: 0px 20px 30px rgba(0, 0, 0, 0.16);">{{ translate('View All Coupons') }}</a>
                    </div>
                </div>
            </div>
        </div>
    @endif -->

    <!-- Category wise Products -->
    <!-- <div id="section_home_categories" class="mb-2 mb-md-3 mt-2 mt-md-3">

    </div> -->

    <!-- Classified Product -->
    <!-- @if (get_setting('classified_product') == 1)
        @php
            $classified_products = get_home_page_classified_products(6);
        @endphp
        @if (count($classified_products) > 0)
            <section class="mb-2 mb-md-3 mt-2 mt-md-3">
                <div class="container">
                    Top Section
                    <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                        Title
                        <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                            <span class="">{{ translate('Classified Ads') }}</span>
                        </h3>
                        Links
                        <div class="d-flex">
                            <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary"
                                href="{{ route('customer.products') }}">{{ translate('View All Products') }}</a>
                        </div>
                    </div>
                    Banner
                    @php
                        $classifiedBannerImage = get_setting('classified_banner_image', null, $lang);
                        $classifiedBannerImageSmall = get_setting('classified_banner_image_small', null, $lang);
                    @endphp
                    @if ($classifiedBannerImage != null || $classifiedBannerImageSmall != null)
                        <div class="mb-3 overflow-hidden hov-scale-img d-none d-md-block">
                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                data-src="{{ uploaded_asset($classifiedBannerImage) }}"
                                alt="{{ env('APP_NAME') }} promo" class="lazyload img-fit h-100 has-transition"
                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                        </div>
                        <div class="mb-3 overflow-hidden hov-scale-img d-md-none">
                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                data-src="{{ $classifiedBannerImageSmall != null ? uploaded_asset($classifiedBannerImageSmall) : uploaded_asset($classifiedBannerImage) }}"
                                alt="{{ env('APP_NAME') }} promo" class="lazyload img-fit h-100 has-transition"
                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                        </div>
                    @endif
                    Products Section
                    <div class="bg-white">
                        <div class="row no-gutters border-top border-left">
                            @foreach ($classified_products as $key => $classified_product)
                                <div
                                    class="col-xl-4 col-md-6 border-right border-bottom has-transition hov-shadow-out z-1">
                                    <div class="aiz-card-box p-2 has-transition bg-white">
                                        <div class="row hov-scale-img">
                                            <div class="col-4 col-md-5 mb-3 mb-md-0">
                                                <a href="{{ route('customer.product', $classified_product->slug) }}"
                                                    class="d-block overflow-hidden h-auto h-md-150px text-center">
                                                    <img class="img-fluid lazyload mx-auto has-transition"
                                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                        data-src="{{ isset($classified_product->thumbnail->file_name) ? my_asset($classified_product->thumbnail->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                                        alt="{{ $classified_product->getTranslation('name') }}"
                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                </a>
                                            </div>
                                            <div class="col">
                                                <h3
                                                    class="fw-400 fs-14 text-dark text-truncate-2 lh-1-4 mb-3 h-35px d-none d-sm-block">
                                                    <a href="{{ route('customer.product', $classified_product->slug) }}"
                                                        class="d-block text-reset hov-text-primary">{{ $classified_product->getTranslation('name') }}</a>
                                                </h3>
                                                <div class="fs-14 mb-3">
                                                    <span
                                                        class="text-secondary">{{ $classified_product->user ? $classified_product->user->name : '' }}</span><br>
                                                    <span
                                                        class="fw-700 text-primary">{{ single_price($classified_product->unit_price) }}</span>
                                                </div>
                                                @if ($classified_product->conditon == 'new')
                                                    <span
                                                        class="badge badge-inline badge-soft-info fs-13 fw-700 p-3 text-info"
                                                        style="border-radius: 20px;">{{ translate('New') }}</span>
                                                @elseif($classified_product->conditon == 'used')
                                                    <span
                                                        class="badge badge-inline badge-soft-danger fs-13 fw-700 p-3 text-danger"
                                                        style="border-radius: 20px;">{{ translate('Used') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif -->

    <!-- Top Sellers -->
    <!-- @if (get_setting('vendor_system_activation') == 1)
        @php
            $best_selers = get_best_sellers(5);
        @endphp
        @if (count($best_selers) > 0)
        <section class="mb-2 mb-md-3 mt-2 mt-md-3">
            <div class="container">
                Top Section
                <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                    Title
                    <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                        <span class="pb-3">{{ translate('Top Sellers') }}</span>
                    </h3>
                    Links
                    <div class="d-flex">
                        <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary"
                            href="{{ route('sellers') }}">{{ translate('View All Sellers') }}</a>
                    </div>
                </div>
                Sellers Section
                <div class="aiz-carousel arrow-x-0 arrow-inactive-none" data-items="5" data-xxl-items="5"
                    data-xl-items="4" data-lg-items="3.4" data-md-items="2.5" data-sm-items="2" data-xs-items="1.4"
                    data-arrows="true" data-dots="false">
                    @foreach ($best_selers as $key => $seller)
                        @if ($seller->user != null)
                            <div
                                class="carousel-box h-100 position-relative text-center border-right border-top border-bottom @if ($key == 0) border-left @endif has-transition hov-animate-outline">
                                <div class="position-relative px-3" style="padding-top: 2rem; padding-bottom:2rem;">
                                    Shop logo & Verification Status
                                    <div class="position-relative mx-auto size-100px size-md-120px">
                                        <a href="{{ route('shop.visit', $seller->slug) }}"
                                            class="d-flex mx-auto justify-content-center align-item-center size-100px size-md-120px border overflow-hidden hov-scale-img"
                                            tabindex="0"
                                            style="border: 1px solid #e5e5e5; border-radius: 50%; box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.06);">
                                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                                data-src="{{ uploaded_asset($seller->logo) }}" alt="{{ $seller->name }}"
                                                class="img-fit lazyload has-transition"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                        </a>
                                        <div class="absolute-top-right z-1 mr-md-2 mt-1 rounded-content bg-white">
                                            @if ($seller->verification_status == 1)
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24.001" height="24"
                                                    viewBox="0 0 24.001 24">
                                                    <g id="Group_25929" data-name="Group 25929"
                                                        transform="translate(-480 -345)">
                                                        <circle id="Ellipse_637" data-name="Ellipse 637" cx="12"
                                                            cy="12" r="12" transform="translate(480 345)"
                                                            fill="#fff" />
                                                        <g id="Group_25927" data-name="Group 25927"
                                                            transform="translate(480 345)">
                                                            <path id="Union_5" data-name="Union 5"
                                                                d="M0,12A12,12,0,1,1,12,24,12,12,0,0,1,0,12Zm1.2,0A10.8,10.8,0,1,0,12,1.2,10.812,10.812,0,0,0,1.2,12Zm1.2,0A9.6,9.6,0,1,1,12,21.6,9.611,9.611,0,0,1,2.4,12Zm5.115-1.244a1.083,1.083,0,0,0,0,1.529l3.059,3.059a1.081,1.081,0,0,0,1.529,0l5.1-5.1a1.084,1.084,0,0,0,0-1.53,1.081,1.081,0,0,0-1.529,0L11.339,13.05,9.045,10.756a1.082,1.082,0,0,0-1.53,0Z"
                                                                transform="translate(0 0)" fill="#3490f3" />
                                                        </g>
                                                    </g>
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24.001" height="24"
                                                    viewBox="0 0 24.001 24">
                                                    <g id="Group_25929" data-name="Group 25929"
                                                        transform="translate(-480 -345)">
                                                        <circle id="Ellipse_637" data-name="Ellipse 637" cx="12"
                                                            cy="12" r="12" transform="translate(480 345)"
                                                            fill="#fff" />
                                                        <g id="Group_25927" data-name="Group 25927"
                                                            transform="translate(480 345)">
                                                            <path id="Union_5" data-name="Union 5"
                                                                d="M0,12A12,12,0,1,1,12,24,12,12,0,0,1,0,12Zm1.2,0A10.8,10.8,0,1,0,12,1.2,10.812,10.812,0,0,0,1.2,12Zm1.2,0A9.6,9.6,0,1,1,12,21.6,9.611,9.611,0,0,1,2.4,12Zm5.115-1.244a1.083,1.083,0,0,0,0,1.529l3.059,3.059a1.081,1.081,0,0,0,1.529,0l5.1-5.1a1.084,1.084,0,0,0,0-1.53,1.081,1.081,0,0,0-1.529,0L11.339,13.05,9.045,10.756a1.082,1.082,0,0,0-1.53,0Z"
                                                                transform="translate(0 0)" fill="red" />
                                                        </g>
                                                    </g>
                                                </svg>
                                            @endif
                                        </div>
                                    </div>
                                    Shop name
                                    <h2 class="fs-14 fw-700 text-dark text-truncate-2 h-40px mt-3 mt-md-4 mb-0 mb-md-3">
                                        <a href="{{ route('shop.visit', $seller->slug) }}"
                                            class="text-reset hov-text-primary" tabindex="0">{{ $seller->name }}</a>
                                    </h2>
                                    Shop Rating
                                    <div class="rating rating-mr-1 text-dark mb-3">
                                        {{ renderStarRating($seller->rating) }}
                                        <span class="opacity-60 fs-14">({{ $seller->num_of_reviews }}
                                            {{ translate('Reviews') }})</span>
                                    </div>
                                    Visit Button
                                    <a href="{{ route('shop.visit', $seller->slug) }}" class="btn-visit">
                                        <span class="circle" aria-hidden="true">
                                            <span class="icon arrow"></span>
                                        </span>
                                        <span class="button-text">{{ translate('Visit Store') }}</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
        @endif
    @endif -->

    <!-- Top Brands -->
    <!-- @if (get_setting('top_brands') != null)
        <section class="mb-2 mb-md-3 mt-2 mt-md-3">
            <div class="container">
                Top Section
                <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                    Title
                    <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">{{ translate('Top Brands') }}</h3>
                    Links
                    <div class="d-flex">
                        <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary"
                            href="{{ route('brands.all') }}">{{ translate('View All Brands') }}</a>
                    </div>
                </div>
                Brands Section
                <div class="bg-white px-3">
                    <div
                        class="row row-cols-xxl-6 row-cols-xl-6 row-cols-lg-4 row-cols-md-4 row-cols-3 gutters-16 border-top border-left">
                        @php
                            $top_brands = json_decode(get_setting('top_brands'));
                            $brands = get_brands($top_brands);
                        @endphp
                        @foreach ($brands as $brand)
                            <div
                                class="col text-center border-right border-bottom hov-scale-img has-transition hov-shadow-out z-1">
                                <a href="{{ route('products.brand', $brand->slug) }}" class="d-block p-sm-3">
                                    <img src="{{ isset($brand->brandLogo->file_name) ? my_asset($brand->brandLogo->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                        class="lazyload h-md-100px mx-auto has-transition p-2 p-sm-4 mw-100"
                                        alt="{{ $brand->getTranslation('name') }}"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                    <p class="text-center text-dark fs-12 fs-md-14 fw-700 mt-2">
                                        {{ $brand->getTranslation('name') }}
                                    </p>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif -->

@endsection

