{# Commented-out section #}
{# 
																																														    <div class="container">
																																														        <tr>
																																														            <th>Text</th>
																																														            <td>{{ question.text }}</td>
																																														        </tr>
																																														        <tr>
																																														            <th>Image</th>
																																														            <td>{{ question.image }}</td>
																																														        </tr>
																																														        <tr>
																																														            <th>IsChecked</th>
																																														            <td>{{ question.isChecked ? 'Yes' : 'No' }}</td>
																																														        </tr>
																																														    </div>
																																														    
																																														    <a href="{{ path('app_questions_index') }}">back to list</a>
																																														    
																																														    <a href="{{ path('app_questions_edit', {'id': question.id}) }}">edit</a>
																																														    
																																														    {{ include('questions/_delete_form.html.twig') }}
																																														    #}