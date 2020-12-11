

<form action="{{ path('login') }}" method="POST">
        <label for="username">Email</label>
        <input type="email" id="username" name="_username" value="{{ last_username }}" />
        
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="_password" />
        
        <div class="clearfix"></div>
        <input type="hidden" name="_target_path" value="tasks" />
        <input type="submit" value="Entrar" />
    </form>




public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('comment', TextareaType::class, array(
            'label' => 'Comentario'
        ))
        ->add('submit', SubmitType::class, array(
            'label' => 'Guardar'
        ));
    }

    
    

<form action="{{ path('login') }}" method="POST">
    
    <textarea id="comment" name="comment"></textarea>
    <input type="submit" value="Entrar" />

</form>    
    
    
 {% if form is defined %}    
    <div class="example-wrapper">
                                {{ form_start(form) }}
                                {{ form_widget(form) }} 
                                {{ form_end(form) }}
    </div>
  {% endif %}
  
  
  
  
  {% if form is defined %}
                        <div class="example-wrapper">
                                {{ form_start(form) }}
                                {{ form_widget(form) }} 
                                {{ form_end(form) }}
                        </div>
                        {% else %}
                        ////////button//////
                         {% endif %}