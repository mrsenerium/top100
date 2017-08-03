<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_emails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('subject');
            $table->string('body', 3000);
            $table->timestamps();
        });

        DB::table('application_emails')->insert([
          [
            'description' => 'Nomination',
            'subject' => 'Top 100 Nomination',
            'body' => '<p>You have been nominated for the Top 100 Outstanding Student Recognition Program.</p>
                       <p>The Butler University Alumni Association and Office of Student Affairs proudly sponsors the 54th Annual Student Recognition Program and Banquet honoring the Top 100 Outstanding Students of 2014-2015. Since 1961, the program has honored students, who through campus leadership, community involvement and academic performance, are great assets to our University. The Student Recognition Program seeks to recognize those who give unselfishly of themselves, who are highly regarded by the entire University community, and who, as future alumni, may take satisfaction in their contribution and service to Butler University.</p><p>You were nominated by a member of the faculty, staff or a fellow student. To accept this nomination, please visit <a target="_blank" href="http://www.butler.edu/top100">www.butler.edu/top100</a> to access and complete your application. &ldquo;Top 100 Application 101&rdquo; sessions will also be held October 1 and 2 at 4:00 p.m. in Jordan Hall 141 for all nominees to further explain the application process. Applicants may attend either session. The deadline to submit your application is Monday, October 20 at 11:59 p.m.</p><p>In order to be considered a Top 100 student at Butler University, students may not be on conduct probation during the application process or the announcement for Top 100 and Top 10. Additionally, students who have been found responsible for an academic integrity violation will not be eligible for the award. Top 100 applicants, by virtue of submitting an application, agree to a student conduct check facilitated by the Office of Student Affairs and know they will be excused from consideration should either conduct probation or academic integrity violations exist.</p><p>If you are selected to the Top 100, you will be asked to participate in a second round of the application process, which includes soliciting recommendations from up to three individuals. If you have any questions on the selection process, please e-mail <a target="_blank" href="mailto:top100@butler.edu">top100@butler.edu</a>. </p><p>Congratulations and good luck!</p>'
          ],
          [
            'description' => 'Nomination Confirmation',
            'subject' => 'Top 100 Nomination Confirmation',
            'body' => '<p>Your nomination for the 54th Annual Top 100 Outstanding Student Recognition Selection Process was successful. The candidate has been notified.</p>'
          ],
          [
            'description' => 'Application Submitted',
            'subject' => 'Top 100 Application Submission',
            'body' => '<p>You have successfully submitted your application for Butler&#39;s Outstanding Student Program. The Top 100 will be announced at the beginning of December. Those selected as part of the Top 100 will then continue to the second round of the application process to determine the Top 10 Men, Top 10 Women, and Most Outstanding Man and Woman.</p><p>Good Luck!</p>'
          ],
          [
            'description' => 'Recommendation Request',
            'subject' => 'Top 100 Recommendation Request',
            'body' => '<p>This recommendation will be used in the process to determine the Top 10 Men and Top 10 Women. Recommendations must be submitted by 11:59 p.m. on Sunday, January 30, 2015. If you are unable to submit a recommendation on behalf of this student, please notify the student directly so that he/she may be able to request one from another individual. Please do not respond to this message, as your reply will be sent to the Top 100 system and not the student.</p>'
          ],
          [
            'description' => 'Recommendation Confirmation',
            'subject' => 'Top 100 Recommendation Confirmation',
            'body' => '<p>Your submission is in support of the candidate being selected as one of the Top 10 Men or Women for the 2014-2015 Outstanding Student Recognition Program. A confirmation email has been sent to the student as well, but only members of the selection committee are able to view recommendations.</p>'
          ],
          [
            'description' => 'Recommendation Confirmation - For Student',
            'subject' => 'Top 100 Recommendation Confirmation',
            'body' => '<p>Only the judges for the Top 100 program will be given access to read the recommendation. If you have any questions, please contact <a target="_blank" href="mailto:top100@butler.edu">top100@butler.edu</a>.</p>'
          ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('application_emails');
    }
}
