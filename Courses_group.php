<div class="container mt-3">

	<h5>Cursuri favorite:</h5>
	<button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#New_group_Modal">Grup nou +</button>

	<!--Modal-new-group--->
	<div class="modal fade" id="New_group_Modal">
	  	<div class="modal-dialog">
	    	<div class="modal-content">

	      		<!-- Modal Header -->
	      		<div class="modal-header">
	        		<h4 class="modal-title">Grup nou</h4>
	        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#New_group_Modal"></button>
	      		</div>

	      		<!-- Modal body -->
	      		<div class="modal-body">
	      			<form action="#">
	      				<div class="mb-3">
						    <label for="Group_name" class="form-label">Nume grup:</label>
						    <input type="text" class="form-control" id="Group_name" placeholder="Nume grup" name="Group_name">
						</div>
	        			<div class="form-check">
					  		<input class="form-check-input" type="checkbox" id="check1" name="option1" value="something">
					  		<label class="form-check-label" for="check1">Curs 1</label>
						</div>
						<div class="form-check">
					      	<input type="checkbox" class="form-check-input" id="check2" name="option2" value="something">
					      	<label class="form-check-label" for="check2">Curs 2</label>
					    </div>
					    <div class="d-grid">
					    	<button type="submit" class="btn btn-secondary btn-block mt-3">Crează</button>
					    </div>
					</form>
	      		</div>

	    	</div>
	  	</div>
	</div>

	<!--Modal-add-course--->
	<div class="modal fade" id="Add_course_Modal">
	  	<div class="modal-dialog">
	    	<div class="modal-content">

	      		<!-- Modal Header -->
	      		<div class="modal-header">
	        		<h4 class="modal-title">Adaugă cursuri</h4>
	        		<button type="button" class="btn-close" data-bs-dismiss="modal" data-bs-target="#Add_course_Modal"></button>
	      		</div>

	      		<!-- Modal body -->
	      		<div class="modal-body">
	      			<form action="#">
	        			<div class="form-check">
					  		<input class="form-check-input" type="checkbox" id="check1" name="option1" value="something">
					  		<label class="form-check-label" for="check1">Curs 1</label>
						</div>
						<div class="form-check">
					      	<input type="checkbox" class="form-check-input" id="check2" name="option2" value="something">
					      	<label class="form-check-label" for="check2">Curs 2</label>
					    </div>
					    <div class="d-grid">
					    	<button type="submit" class="btn btn-secondary btn-block mt-3">Adaugă</button>
					    </div>
					</form>
	      		</div>

	    	</div>
	  	</div>
	</div>

	<div class="accordion accordion-flush mt-3" id="accordionFlushExample">

	  	<div class="accordion-item">
	    	<h2 class="accordion-header" id="heading_group1">
	      		<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapse_group1">Grupa 1</button>
	    	</h2>
	    	<div id="collapse_group1" class="accordion-collapse collapse" data-bs-parent="#accordion_group">
	      		<div class="accordion-body">
	        		<div class="list-group">
					    <a href="#" class="list-group-item list-group-item-action">Curs 1</a>
					    <a href="#" class="list-group-item list-group-item-action">Curs 2</a>
					    <a href="#" class="list-group-item list-group-item-action">Curs 3</a>
					    <button type="submit" class="btn btn-secondary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#Add_course_Modal">+</button>
					</div>
	        		
	        		
	      		</div>
	    	</div>
		</div>

		<div class="accordion-item">
		    <h2 class="accordion-header" id="heading_group2">
		      	<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_group2">Grupa 2</button>
		    </h2>
    		<div id="collapse_group2" class="accordion-collapse collapse" data-bs-parent="#accordion_group">
      			<div class="accordion-body">
        			<div class="list-group">
					    <a href="#" class="list-group-item list-group-item-action">Curs 1</a>
					    <a href="#" class="list-group-item list-group-item-action">Curs 2</a>
					    <a href="#" class="list-group-item list-group-item-action">Curs 3</a>
					    <button type="submit" class="btn btn-secondary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#Add_course_Modal">+</button>
					</div>
	        		
      			</div>
    		</div>
  		</div>

	</div>
</div>