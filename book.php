<?php include_once('template/mainheader.php') ?>

<main class="container pt-3 pb-5 mt-3">
  <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
    <?php
    $buses = [
      [
        'bus_no' => '101',
        'img' => 'asset/images/bus1.jpg',
        'title' => 'Sincroda',
        'inclusions' => ['Free Snacks', 'Wi-Fi', 'Reclining Seats'],
        'price' => 350
      ],
      [
        'bus_no' => '102',
        'img' => 'asset/images/bus2.jpg',
        'title' => 'DLTB',
        'inclusions' => ['Air-conditioned', 'USB Charging Port', 'On-board Entertainment'],
        'price' => 320
      ],
      [
        'bus_no' => '103',
        'img' => 'asset/images/bus3.jpg',
        'title' => 'LLI',
        'inclusions' => ['Spacious Legroom', 'On-board Comfort Kit', 'Wi-Fi'],
        'price' => 300
      ],
      [
        'bus_no' => '104',
        'img' => 'asset/images/bus4.jpg',
        'title' => 'HM',
        'inclusions' => ['Air-conditioned', 'Bottle of Water', 'Adjustable Seats'],
        'price' => 280
      ],
    ];

    foreach ($buses as $bus) {
      echo '
      <div class="col">
        <div class="card h-100 shadow">
          <img src="' . $bus['img'] . '" class="card-img-top" alt="' . $bus['title'] . '">
          <div class="card-body">
            <h5 class="card-title">' . $bus['title'] . '</h5>
            <p class="card-text"><strong>Bus No#:</strong> ' . $bus['bus_no'] . '</p>
            <p class="card-text"><strong>Inclusions:</strong><br>';
      foreach ($bus['inclusions'] as $inc) {
        echo '✔️ ' . $inc . '<br>';
      }
      echo '</p>
            <p class="card-text"><strong>Price:</strong> ₱' . $bus['price'] . '</p>
            <button 
              type="button" 
              class="btn btn-primary w-100 select-bus-btn" 
              data-bs-toggle="modal" 
              data-bs-target="#busModal"
              data-title="' . $bus['title'] . '"
              data-img="' . $bus['img'] . '"
              data-price="' . $bus['price'] . '"
              data-busno="' . $bus['bus_no'] . '"
              data-inclusions="' . implode(',', $bus['inclusions']) . '"
            >Select</button>
          </div>
        </div>
      </div>';
    }
    ?>
  </div>
</main>

<div class="modal fade" id="busModal" tabindex="-1" aria-labelledby="busModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="busModalLabel">Selected Bus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img id="modalBusImg" src="" alt="Bus Image" class="img-fluid rounded mb-3" style="max-height: 250px;">
        <h4 id="modalBusTitle"></h4>
        <p class="mb-1"><strong>Bus No#:</strong> <span id="modalBusNo"></span></p>
        <p class="fs-5"><strong>Price:</strong> ₱<span id="modalBusPrice"></span></p>
        <p><strong>Inclusions:</strong></p>
        <ul id="modalBusInclusions" class="list-unstyled"></ul>
      </div>
      <div class="modal-footer">
        <a href="Select.php" id="bookNowBtn" class="btn btn-success w-100">Book Now</a>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  document.querySelectorAll('.select-bus-btn').forEach(button => {
    button.addEventListener('click', () => {
      const title = button.getAttribute('data-title');
      const img = button.getAttribute('data-img');
      const price = button.getAttribute('data-price');
      const busNo = button.getAttribute('data-busno');
      const inclusions = button.getAttribute('data-inclusions').split(',');

      document.getElementById('modalBusTitle').textContent = title;
      document.getElementById('modalBusImg').src = img;
      document.getElementById('modalBusPrice').textContent = price;
      document.getElementById('modalBusNo').textContent = busNo;

      const incList = document.getElementById('modalBusInclusions');
      incList.innerHTML = '';
      inclusions.forEach(inc => {
        const li = document.createElement('li');
        li.innerHTML = '✔️ ' + inc.trim();
        incList.appendChild(li);
      });

      const bookBtn = document.getElementById('bookNowBtn');
      const params = new URLSearchParams({
        bus_title: title,
        bus_no: busNo,
        bus_price: price
      });
      bookBtn.href = 'Select.php?' + params.toString();
    });
  });
</script>
