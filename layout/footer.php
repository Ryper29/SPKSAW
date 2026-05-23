<footer>
    <div class="footer clearfix mb-0 text-muted">
        <div class="float-start">
            <p class="tooltip-container">Sistem ini dikembangkan sebagai prototipe SPK pemilihan jurusan kuliah.</span>
                <span class="tooltip-text">Lampung</span>
            </p>
        </div>
        <div class="float-end">
		<p>
			&copy; <span id="year"></span> 
			<a href="https://www.instagram.com/rifki.y.p/" target="_blank" rel="noopener noreferrer">
				Ripki Ganteng
			</a>
			| SPK Pemilihan Jurusan Kuliah
		</p>
</div>
    </div>
</footer>

<style>
    /* CSS untuk Tooltip */
    .tooltip-container {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }

    .tooltip-container .tooltip-text {
        visibility: hidden;
        width: 120px;
        background-color: #333;
        color: #fff;
        text-align: center;
        border-radius: 5px;
        padding: 5px 0;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        /* Position above the emoji */
        left: 50%;
        margin-left: -60px;
        opacity: 0;
        transition: opacity 0.3s;
        /* Arrow styling */
        border-width: 5px;
        border-style: solid;
        border-color: transparent transparent #333 transparent;
        border-radius: 10px;
    }

    .tooltip-container:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
    }
</style>

<script>
    // JavaScript to set the current year
    document.getElementById('year').textContent = new Date().getFullYear();
</script>