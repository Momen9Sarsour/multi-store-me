<div class="container sectionProduct">

      <div class="product-container">

          <div class="row">
            <div class="image-container">
              <a href="{{ route('categ.show', $category->slug) }}">
                  <div class="image">
                      <img src="{{ $category->image_url }}" alt="No image Product" class="image">
                  </div>
                 <div class="title1"> <span class="category"></span>
                  <h4><a href="{{ route('categ.show', $category->slug) }}">{{ $category->name }}</a></h4></div>
              </a>
            </div>
          </div>
          <div class="prod">
              <!-- Your product information here -->
          </div>
      </div>

  </div>

  <p>&nbsp;</p>
  <p>&nbsp;</p>
