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

	const buttons = form.getElementsByTagName( 'button' );
	const select = [];
	for ( const button of buttons ) {
		select.push( button.textContent );
	}

	const body = new FormData( form );
	body.append( 'selected', e.submitter.textContent );
	body.append( 'select', select );

	fetch( action, {
		method: form.method,
		body,
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
		.catch( () => {
			addMessage( form, 'おっと！なにか問題が発生しました。' );
		} );
};

// 複数フォームを設定した場合に考慮
const forms = document.querySelectorAll(
	'form[name="beastfeedbacks_vote_form"]'
);
for ( const form of forms ) {
	form.addEventListener( 'submit', submit );
}
