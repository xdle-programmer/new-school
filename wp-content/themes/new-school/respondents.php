<?php

$blogusers = get_users( 'role=subscriber' );

?>

    <table class="respondents">
        <tr>
            <th>
                Респондент
            </th>
            <th>
                Код родителя
            </th>
            <th>
                Имя
            </th>
            <th>
                Отчество
            </th>
            <th>
                В каком классе учится ребенок
            </th>
            <th>
                Возраст
            </th>
            <th>
                Образование
            </th>
        </tr>

		<?php

		foreach ( $blogusers as $user ) {
			$meta  = get_user_meta( $user->ID );
			$about = json_decode( $meta['about'][0] );

			echo '<tr>';

			echo '<td>';
			echo $user->user_login;

			echo '</td>';

			echo '<td>';
			echo $meta['parent_code'][0];
			echo '</td>';

			echo '<td>';
			echo $meta['fname'][0];
			echo '</td>';

			echo '<td>';
			echo $meta['mname'][0];
			echo '</td>';

			foreach ( $about as $aboutItem ) {
				if ( $aboutItem->title === 'В каком классе сейчас учится Ваш ребенок/дети (посещает детский сад)?' ) {
					echo '<td>';

					if ( count( $aboutItem->answers ) > 1 ) {
						echo $aboutItem->answers[0] . ', ' . $aboutItem->answers[1];
					} else {
						echo $aboutItem->answers[0];
					}


					echo '</td>';
				}
			}

			foreach ( $about as $aboutItem ) {
				if ( $aboutItem->title === 'Ваш возраст:' ) {
					echo '<td>';
					echo $aboutItem->answers[0];
					echo '</td>';
				}
			}

			foreach ( $about as $aboutItem ) {
				if ( $aboutItem->title === 'Ваше образование:' ) {
					echo '<td>';
					echo $aboutItem->answers[0];
					echo '</td>';
				}
			}


			echo '</tr>';
		}

		?>

    </table>
