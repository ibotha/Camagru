<div id="cameracontainer">
	<div id="camera">
		<video autoplay="true" id="webcam"></video>
		<canvas id="image"></canvas>
		<div id="sticker"></div>
	</div>
	<button id="capture"></button>
	<div id="camoptions">
		<div class="field" style="display: initial;">
			<div style="max-width: 500px; margin: 20px auto 20px auto;">
				<input id="titleinput" placeholder="Title">
			</div>
		</div>
		<div class="options">
			<button id="post" class="greyed">Post</button>
			<button id="cancel">Cancel</button>
		</div>
	</div>
	<div id="stickers"></div>
	<div id="upload">
		<div class="options">
			<p>Or Upload:</p>
			<input type="file" accept="image/*" id="uploadinput">
		</div>
	</div>
</div>