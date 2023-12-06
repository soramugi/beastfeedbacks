const addMessage = ( form, message ) => {
	const messageElement = document.createElement( 'span' );
	messageElement.textContent = message;
	form.parentElement.insertBefore( messageElement, form.nextSibling );
};

const submit = ( e ) => {
	e.preventDefault();
	e.submitter.setAttribute( 'disabled', true );

	const form = e.target;
	const action = form.getAttribute( 'action' );

	fetch( action, {
		method: form.method,
		body: new FormData( form ),
	} )
		.then( ( response ) => {
			if ( ! response.ok ) {
				throw new Error( response );
			}
			return response.json();
		} )
		.then( ( data ) => {
			addMessage( form, data.message );
		} )
		.catch( ( error ) => {
			console.error( error );
			addMessage( form, 'おっと！なにか問題が発生しました。' );
		} );
};

// 複数フォームを設定した場合に考慮
const forms = document.querySelectorAll(
	'form[name="beastfeedbacks_survey_form"]'
);
for ( const form of forms ) {
	form.addEventListener( 'submit', submit );
}
