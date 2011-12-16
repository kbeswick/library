<?php include('header.php'); ?>
      <script type="text/javascript" src="/js/reserves.js"></script>
      <div class="content">
        <div class="light">
        <h3 class="show_instructions"><a href="#" onClick='showInstructions("english")'>Show English Instructions</a> | </h3>
        <h3 class="show_instructions"><a href="#" onClick='showInstructions("french")'>Montrez Les Instructions Françaises</a></h3>
        <div id="instructions" style="display:none">
          <div id="instructions_english" style="display:none">
            <p>Professors may place library material which is in high demand on
            reserve. By placing an item on reserve, a professor ensures that the
            maximum number of students will have access to the material.</p>
            <p>Reserve material is kept at the circulation desk and is available on a
            limited-term loan period from two hours to three days.</p>
            <p>To access a list of reserves for a given course, please select the
            course below. You can sort the list either by course or instructor by
            clicking on the corresponding heading in the list.</p>
            <p>When you click on a course, a list of the reserves for that course will be
            brought up in the catalogue. To obtain a reserve number for a specific
            book, click on the book title, then refer to the call number under the
            copy summary for that book as outlined in red in the images below. The
            call number may just contain the reserve number, or the reserve number
            followed by the book's actual call number. Ask for a reserve at the
            circulation desk using this reserve number.</p>
          </div>

          <div id="instructions_french" style="display:none">
            <p>Les professeurs peuvent mettre en réserve des documents très en
            demande. Les professeurs placent des documents en réserve pour y garantir
            l'accès à un maximum d’étudiants.</p>
            <p>Ces documents sont conservés au comptoir du prêt et peuvent être
            empruntés pour une période de deux heures à trois jours.</p>
            <p>Pour accéder aux documents en réserve, sélectionnez votre cours parmi
            la liste si-dessous. Vous pouvez mettre la liste en order alphabétique par
            cours ou par professeur(e).</p>
            <p>Lorsque vous sélectionnez un cours, une liste de documents en réserve
            apparaîtra dans le catalogue. Pour obtenir le numéro de réserve, cliquez
            sur le titre du livre. Un numéro de réserve se trouve où la cote du livre
            apparait normalement (indiqué en rouge si-dessous). C'est ce numéro de
            réserve qui doit être demandé au comptoir du prêt afin d'obtenir votre
            document.</p>
          </div>

          <img src="reserves.png" width="640px" height="393px" />
          <img src="reserves2.png" />
        </div>
        </div>
      </div>
      <div id="search" class="light">
        <table>
          <tr>
            <td><span class="label">Narrow by Course Code:</span></td>
            <td>
              <input dojoType="dijit.form.TextBox" id="course_search" intermediateChanges="true" onChange="grid.filter({ course_code: dijit.byId('course_search').attr('value').toUpperCase() + '*' });"></input>
            </td>
          </tr>
          <tr>
            <td><span class="label">Narrow by Instructor (Last Name):</span></td>
            <td>
              <input dojoType="dijit.form.TextBox" id="ins_search" intermediateChanges="true" 
                onChange="grid.filter({ instructor: dijit.byId('ins_search').attr('value').substr(0,1).toUpperCase() + dijit.byId('ins_search').attr('value').substr(1) + '*' });"
                ></input>
            </td>
          </tr>
        </table>
      </div>

      <div id="menu" class="light">
        <span class="label">
          Filter by Course Code: &nbsp; &nbsp; &nbsp;
        </span>
        <span>
          <a href="#" onClick="narrowList( new Array('A','B','C') );">A-C</a>&nbsp;&nbsp;
          <a href="#" onClick="narrowList( new Array('D','E','F') );">D-F</a>&nbsp;&nbsp;
          <a href="#" onClick="narrowList( new Array('G','H','I') );">G-I</a>&nbsp;&nbsp;
          <a href="#" onClick="narrowList( new Array('J','K','L') );">J-L</a>&nbsp;&nbsp;
          <a href="#" onClick="narrowList( new Array('M','N','O') );">M-O</a>&nbsp;&nbsp;
          <a href="#" onClick="narrowList( new Array('P','Q','R') );">P-R</a>&nbsp;&nbsp;
          <a href="#" onClick="narrowList( new Array('S','T','U') );">S-U</a>&nbsp;&nbsp;
          <a href="#" onClick="narrowList( new Array('V','W','X','Y','Z') );">V-Z</a>&nbsp;&nbsp
          <a href="#" onClick="narrowList( 'ENVISION' );">ENVISION</a>&nbsp;&nbsp;
          <a href="#" onClick="narrowList( new Array('*') );">Show All</a>
        </span>
      </div>
      <div class="light">
        <div id="grid" class="grid" jsId="grid" dojoType="dojox.grid.DataGrid" store="reservesStore" structure="layout" 
          query="{ course_code:'*' }" autoHeight="true">
        </div>
      </div>
<?php include('footer.php'); ?>
