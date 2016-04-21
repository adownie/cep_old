(function($) {
$(document).ready(function() {

	/* INIT */
		/* Make the title talk */
		startTitleActivityIndicator();
		showIframeLoadingOverlay();

		/* Start loading layout selector */
			loadLayoutSelector();

		/* Set up variables */ 
			Headway.iframe = $('iframe#content');

			/* Parse the JSON in the Headway l10n array */
			Headway.blockTypeURLs = $.parseJSON(Headway.blockTypeURLs.replace(/&quot;/g, '"'));
			Headway.allBlockTypes = $.parseJSON(Headway.allBlockTypes.replace(/&quot;/g, '"'));
			Headway.ranTour = $.parseJSON(Headway.ranTour.replace(/&quot;/g, '"'));

			Headway.designEditorProperties = $.parseJSON(Headway.designEditorProperties.replace(/&quot;/g, '"'));

		/* Create the new object and initiate the mode and the iframe */
			Headway.instance = new window['visualEditorMode' + Headway.mode.capitalize()]();

			if ( typeof Headway.instance.init == 'function' )
				Headway.instance.init();

		/* iframe focusing and blurring */
			Headway.iframe.bind('mouseleave', function() {
				$(this).trigger('blur');

				/* Hide any tooltips */
				$i('[data-hasqtip]').qtip('disable', true);
			});

			Headway.iframe.bind('mouseenter mousedown', function() {
				//If there is another textarea/input that's focused, don't focus the iframe.
				if ( $('textarea:focus, input:focus').length === 1 )
					return;

				$i('[data-hasqtip]').qtip('enable');
				$(this).trigger('focus');
			});

		/* If panel is empty then add body class */
			if ( !$('ul#panel-top').find('li').length )
				$('body').addClass('panel-empty');

		/* Setup iframe callback */
			waitForIframeLoad(Headway.instance.iframeCallback);
	/* END INIT */


	/* TOUCH OPTIMIZATION */
		/* Keep Menu From Making the Whole VE From Bouncing on iPad */
		$('#menu').bind('touchmove', function(event) {
			event.preventDefault();
		})
	/* END TOUCH OPTIMIZATION */


	/* MODE SWITCHING */
		$('ul#modes li a').bind('click', function(){
			$(this).attr('href', $(this).attr('href') + '&ve-layout=' + Headway.currentLayout);
		});
	/* END MODE SWITCHING */


	/* SKINS PANEL */
		/* Scrolling */
			if ( navigator.userAgent.indexOf('WebKit') === -1 && !$.support.touch )
				$('div#skins-scroller').perfectScrollbar().addClass('ps-horizontal-scrolling');

		var showSkinsPanel = function() {

			/* Add active class to skins button */
				$('li#skins-button').addClass('active');

			/* Fade in skins black overlay */
				$('#skins-panel-overlay').fadeIn(500);

			/* Open skins panel and drop it down from top */
				$('#skins-panel').show();

			/* Load skin images */
				$('#skins-panel img[data-src]').each(function() {
					var dataSrc = $(this).attr('data-src');

					if ( dataSrc ) {
						$(this).attr('src', $(this).attr('data-src'));
						$(this).removeAttr('data-src');
					}
				});

			/* Use setTimeout here because going straight from show to adding the class completely skips the transition */
				setTimeout(function() {
					$('#skins-panel').addClass('skins-panel-open');
				}, 5);

		}


		var hideSkinsPanel = function() {

			/* Remove active class from skins button */
				$('li#skins-button').removeClass('active');

			/* Fade out skins black overlay */
				$('#skins-panel-overlay').fadeOut(300);

			/* Hide skins panel */
				$('#skins-panel').removeClass('skins-panel-open');

		}


		$('li#skins-button span').bind('click', function() {

			/* If this button DOES NOT have active class, then we're opening skins panel.  Otherwise we're closing it */
				if ( !$(this).parent().hasClass('active') )
					return showSkinsPanel();

			return hideSkinsPanel();

		});


		/* Clicking overlay should close skins panel */
			$('#skins-panel-overlay').on('click', hideSkinsPanel);

		/* Bind skin buttons */
			/* Activate */
			$('#skins-panel').on('click', '.skin .skin-activate, .skin .skin-thumb, .skin .skin-name', function(event) {

				if ( $(event.originalEvent.target).is('.skin-delete') || $(event.originalEvent.target).is('.skin-toolbar') )
					return;

				var skin = $(this).parents('.skin').first();
				var skinID = skin.data('skin-id');

				if ( skin.hasClass('skin-activated') )
					return;

				/* Remove active state from existing active skin */
					var previousActivatedSkin = $('#skins .skin-activated');

					previousActivatedSkin.removeClass('skin-activated');

				/* Set active state on new skin */
					skin.addClass('skin-activated');

				/* Send AJAX Request to switch skins */
					$.post(Headway.ajaxURL, {
						security: Headway.security,
						action: 'headway_visual_editor',
						method: 'switch_skin',
						skin: skinID
					}, function(response) {

						/* Change Live CSS */
							if ( $('textarea#live-css').length && typeof liveCSSEditor != 'undefined' ) {

								$('textarea#live-css').val(response['live-css']);
								liveCSSEditor.setValue($('textarea#live-css').val());

							}

						/* Change column options */
							$('#input-columns .ui-slider').slider('option', 'value', response['columns']);
							$('#input-general-columns').val(response['columns']);

							$('#input-column-width .ui-slider').slider('option', 'value', response['column-width']);
							$('#input-general-column-width').val(response['column-width']);

							$('#input-gutter-width .ui-slider').slider('option', 'value', response['gutter-width']);
							$('#input-general-gutter-width').val(response['gutter-width']);

						/* Reload layout selector and iframe.  Switch to first customized layout, then try the selected layout and if it does not exist then get any layout and reload */
							loadLayoutSelector(function () {

								if ( $('#layout-selector-pages').find('.layout-item-customized').first().length === 1 ) {
									switchToLayout($('#layout-selector-pages').find('.layout-item-customized').first(), true);
								} else if ( $('.layout-selected > span.layout').length ) {
									switchToLayout($('.layout-selected > span.layout'), true);
								} else {
									switchToLayout($('span.layout[data-layout-id]').first(), true);
								}

								/* Reload DE */
									if ( typeof designEditor != 'undefined' ) {

										$.when(designEditorRequestElements(true)).then(function() {
											designEditor.setupElementSelector.apply(designEditor);
										});

									}

								/* Show notification */
									showNotification({
										id: 'skin-activated-' + skinID,
										message: 'Template Activated: ' + skin.find('.skin-name').text(),
										closeTimer: 5000,
										closable: true,
									});				

								/* Hide skin panel */
								hideSkinsPanel();

							});

					});

			});

			/* Delete */
			$('#skins-panel').on('click', '.skin .skin-delete', function() {

				var skin = $(this).parents('.skin').first();
				var skinID = skin.data('skin-id');

				if ( !confirm('Are you sure you want to delete this template?  All design settings, blocks, and layout settings for this template will be deleted.') )
					return;

				/* Send AJAX Request to switch skins */
					$.post(Headway.ajaxURL, {
						security: Headway.security,
						action: 'headway_visual_editor',
						method: 'delete_skin',
						skin: skinID
					}, function(response) {

						if ( response != 'success' ) {

							return showErrorNotification({
								id: 'unable-to-delete-skin',
								message: 'Unable to delete template.',
								closeTimer: 7000,
								closable: true
							});

						}

						skin.fadeOut(500, function() {
							$(this).remove();
						});

					});

			});

		/* Skin Upload button */
			$('#skins-panel #upload-skin-button').on('click', function() {
				$('#upload-skin input[type="file"]').first().trigger('click');
			});


			$('#upload-skin input[type="file"]').on('change', function(event) {

				if ( event.target.files[0].name.split('.').slice(-1)[0] != 'json' )
					return alert("Invalid template.\n\nPlease make sure that you have unzipped the Headway Template.  You should be uploading a .json file.");

				var skinFile = $(this).get(0).files[0];

				if ( skinFile && typeof skinFile.name != 'undefined' && typeof skinFile.type != 'undefined' ) {

					var skinReader = new FileReader();

					skinReader.onload = function(e) {

						var skinJSON = e.target.result;
						var skin = JSON.parse(skinJSON);

						/* Check to be sure that the JSON file is a layout */
							if ( skin['data-type'] != 'skin' )
								return alert('Cannot load template.  Please insure that the file is a valid Headway Template.');

						showNotification({
							id: 'installing-skin',
							message: 'Installing Template: ' + skin['name'],
							closeTimer: false,
							closable: false
						});

						installSkin(skin);

					}

					skinReader.readAsText(skinFile);

				} else {

					alert('Cannot load template.  Please insure that the file is a valid Headway Template.');

				}

			});


				installSkin = function(skin) {

					if ( typeof skin['image-definitions'] == 'object' && Object.keys(skin['image-definitions']).length ) {

						var numberOfImages = Object.keys(skin['image-definitions']).length;
						var importedImages = {};

						showNotification({
							id: 'skin-importing-images',
							message: 'Importing Images...',
							closeTimer: false,
							closable: false
						});

						var importSkinImage = function(imageID) {

							/* Update notification for image import */
								var imageIDInt = parseInt(imageID.replace('%%', '').replace('IMAGE_REPLACEMENT_', ''));

								updateNotification('skin-importing-images', 'Importing Image (' + imageIDInt + '/' + numberOfImages + ')');

							/* Do the AJAX request to upload the image */
								var imageImportXhr = $.post(Headway.ajaxURL, {
									security: Headway.security,
									action: 'headway_visual_editor',
									method: 'import_image',
									imageID: imageID,
									imageContents: skin['image-definitions'][imageID]
								}, null, 'json')
									.always(function(response) {

										/* Update notification */

										/* Check if error.  If so, fire notification */
											if ( typeof response['url'] == 'undefined' ) {
												var response = 'ERROR';

												showNotification({
													id: 'skin-importing-images-error-' + imageIDInt,
													message: 'Error Importing Image #' + imageIDInt,
													closeTimer: 10000,
													closable: true,
													error: true
												});
											}

										/* Store uploaded image URL */
											importedImages[imageID] = response;

										/* Check if there are more images to upload.  If so, upload them. */
											var nextImageID = '%%IMAGE_REPLACEMENT_' + (parseInt(imageID.replace('%%', '').replace('IMAGE_REPLACEMENT_', '')) + 1) + '%%';

											if ( typeof skin['image-definitions'][nextImageID] != 'undefined' ) {

												importSkinImage(nextImageID);

										/* If not, finalize skin installation */
											} else {

												/* Hide notification since images are uploaded is complete */
												hideNotification('skin-importing-images');

												/* Finalize */
												skin['imported-images'] = importedImages;

												finalizeSkinInstallation(skin);

											}

									});
							/* End doing AJAX request to upload image */

						}

						importSkinImage('%%IMAGE_REPLACEMENT_1%%');

					} else {

						finalizeSkinInstallation(skin);

					}

				}


					finalizeSkinInstallation = function(skin) {

						/* Remove image definitions from skin array since they've already been imported */
						if ( typeof skin['image-definitions'] != 'undefined' )
							delete skin['image-definitions'];

						/* Do AJAX request to install skin */
						return $.post(Headway.ajaxURL, {
							security: Headway.security,
							action: 'headway_visual_editor',
							method: 'install_skin',
							skin: JSON.stringify(skin)
						}).done(function(data) {

							var skin = data;

							if ( typeof skin['error'] !== 'undefined' || typeof skin['name'] == 'undefined' ) {

								if ( typeof skin['error'] == 'undefined' )
									skin['error'] = 'Could not install template.';

								return showNotification({
									id: 'skin-not-installed',
									message: 'Error: ' + skin['error'],
									closable: true,
									closeTimer: false,
									error: true
								});

							}

							hideNotification('installing-skin');

							showNotification({
								id: 'skin-installed',
								message: skin['name'] + ' successfully installed.',
								closeTimer: 5000
							});

							var skinNode = '\
								<div class="skin" data-skin-id="' + skin['id'] + '">\
									<div class="skin-thumb">\
										<img src="'  + skin['image-url'] + '" alt="" />\
										<div class="skin-toolbar">\
											<span class="skin-version">' + skin['version'] + '</span>\
											\
											<span class="skin-activate tooltip icon-checkmark-sharp skin-button" title="Activate Template"></span>\
											<span class="skin-delete tooltip icon-remove skin-button" title="Delete Template"></span>\
										</div>\
									</div>\
										<h2 class="skin-name">' + skin['name'] + '</h2>\
										<span class="skin-author">By ' + skin['author'] + '</span>\
								</div><!-- .skin -->';

							$(skinNode)
								.css({opacity: 0})
								.appendTo($('#skins-scroller'))
								.animate({opacity: 1}, 500);

						}).fail(function(data) {

							showNotification({
								id: 'skin-not-installed',
								message: 'Error: Could not install template.',
								closable: true,
								closeTimer: false,
								error: true
							});

						});

					}

		/* Skin Export */
			$('#skins-panel #open-export-skin-button').on('click', function() {

				var skinsPanel = $('#skins-panel #skins');

				if ( skinsPanel.hasClass('export-skin-visible') )
					skinsPanel.removeClass('export-skin-visible');
				else
					skinsPanel.addClass('export-skin-visible');

			});


			$('#skins-panel #export-skin-close').on('click', function() {

				$('#skins-panel #skins').removeClass('export-skin-visible');

			});


			$('#skins-panel #export-skin-button').on('click', function() {

				var params = {
					'security': Headway.security,
					'action': 'headway_visual_editor',
					'method': 'export_skin',
					'skin-info': $('#skin-export form').serialize()
				}

				var exportURL = Headway.ajaxURL + '?' + $.param(params);

				return window.open(exportURL);

			});


		/* Add Blank Skin */
			$('#skins-panel #add-blank-skin-button').on('click', function() {

				var skinName = window.prompt('Please enter a name for the new template:' , 'Template Name');

				if ( !skinName || $('#notification-adding-blank-skin').length )
					return;

				/* Perform AJAX request to create the skin and get the ID and name */
					showNotification({
						id: 'adding-blank-skin',
						message: 'Adding New Skin...',
						closable: false,
						closeTimer: false
					});

					$.post(Headway.ajaxURL, {
						security: Headway.security,
						action: 'headway_visual_editor',
						method: 'add_blank_skin',
						skinName: skinName
					}, function(response) {

						hideNotification('adding-blank-skin');

						var skinID = response['id'];
						var skinName = response['name'];

						var skinNode = '\
							<div class="skin" data-skin-id="' + skinID + '">\
								<div class="skin-thumb">\
									<div class="skin-toolbar">\
										<span class="skin-activate tooltip icon-checkmark-sharp skin-button" title="Activate Template"></span>\
										<span class="skin-delete tooltip icon-remove skin-button" title="Delete Template"></span>\
									</div>\
								</div>\
									<h2 class="skin-name">' + skinName + '</h2>\
							</div><!-- .skin -->';

						$(skinNode)
							.css({opacity: 0})
							.appendTo($('#skins-scroller'))
							.animate({opacity: 1}, 500);

					}, 'json');

			});
	/* END SKINS PANEL */


	/* VIEW SITE BUTTON */
		$('#menu-link-view-site a').bind('click', function(){
			$(this).attr('href', Headway.homeURL + '/?headway-trigger=layout-redirect&layout=' + Headway.currentLayout);
		});
	/* END MODE SWITCHING */


	/* SAVE BUTTON */
		$('span#save-button').click(function() {

			save();

			return false;

		});
	/* END SAVE BUTTON */


	/* BOXES */
		setupStaticBoxes();

		/* Make clicking box overlay close visible box for lazy people like me. */
		$('div.black-overlay').on('click', function(){

			var id = $(this).attr('id').replace('black-overlay-', '');

			if ( $('#' + id).length === 0 )
				return;

			if ( $('#qtip-tour').is(':visible') )
				return;

			closeBox(id);

		});
	/* END BOXES */


	/* LAYOUT SWITCHER */
		/* Make open do cool stuff */
		$('div#layout-selector-select-content').click(function(){

			toggleLayoutSelector();

			return false;

		});


		/* Tabs */
		$('div#layout-selector').tabs();


		/* Handle Scrolling */
			if ( navigator.userAgent.indexOf('WebKit') === -1 && !$.support.touch ) {

				$('div#layout-selector-pages').perfectScrollbar();
				$('div#layout-selector-templates').perfectScrollbar();

			}

		/* Make buttons work */
		$('div#layout-selector').delegate('span.edit', 'click', function(event){

			if ( typeof allowVECloseSwitch !== 'undefined' && allowVECloseSwitch === false ) {

				if ( !confirm('You have unsaved changes, are you sure you want to switch layouts?') ) {
					return false;
				} else {
					disallowSaving();
				}

			}

			showIframeLoadingOverlay();

			//Switch layouts
			switchToLayout($(this).parents('span.layout'));

			/* Hide layout selector */
			hideLayoutSelector();

			event.preventDefault();

		});

		$('div#layout-selector').delegate('span.revert', 'click', function(event){

			if ( !confirm('Are you sure you wish to reset this layout?  All blocks and content will be removed from this layout.\n\nPlease note: Any block that is mirroring a block on this layout will also lose its settings.') ) {
				return false;
			}

			var revertedLayout = $(this).parents('span.layout');
			var revertedLayoutID = revertedLayout.attr('data-layout-id');
			var revertedLayoutName = revertedLayout.find('strong').text();

			/* Add loading indicators */
			showIframeLoadingOverlay();

			changeTitle('Visual Editor: Reverting ' + revertedLayoutName);
			startTitleActivityIndicator();

			/* Remove customized status from current layout */
			revertedLayout.parent().removeClass('layout-item-customized');

			/* Find the layout that's customized above this one */
			var parentCustomizedLayout = $(revertedLayout.parents('.layout-item-customized:not(.layout-selected)')[0]);
			var parentCustomizedLayoutID = parentCustomizedLayout.find('> span.layout').attr('data-layout-id');

			var topLevelCustomized = $($('div#layout-selector-pages > ul > li.layout-item-customized')[0]);
			var topLevelCustomizedID = topLevelCustomized.find('> span.layout').attr('data-layout-id');

			var selectedLayout = parentCustomizedLayoutID ? parentCustomizedLayout : topLevelCustomized;
			var selectedLayoutID = parentCustomizedLayoutID ? parentCustomizedLayoutID : topLevelCustomizedID;

			/* If the user gets on a revert frenzy and reverts all pages, then it should fall back to the blog index or front page (if active) */
			if ( typeof selectedLayoutID == 'undefined' || !selectedLayoutID ) {

				selectedLayoutID = Headway.frontPage == 'posts' ? 'index' : 'front_page';
				selectedLayout = $('div#layout-selector-pages > ul > li > span[data-layout-id="' + selectedLayoutID + '"]').parent();

			}

			/* Switch to the next higher-up layout */
			switchToLayout(selectedLayout, true, false);

			/* Delete everything from the reverted layout */
			$.post(Headway.ajaxURL, {
				security: Headway.security,
				action: 'headway_visual_editor',
				method: 'revert_layout',
				layout_to_revert: revertedLayoutID
			}, function(response) {

				if ( response === 'success' ) {
					showNotification({
						id: 'layout-reverted',
						message: '<em>' + revertedLayoutName + '</em> successfully reverted!'
					});
				} else {
					showErrorNotification({
						id: 'error-could-not-revert-layout',
						message: 'Error: Could not revert layout.'
					});
				}

			});

			return false;

		});

		$('div#layout-selector').delegate('span#add-template', 'click', function(event) {

			var templateName = $('#template-name-input').val();

			//Do the AJAX request for the new template
			$.post(Headway.ajaxURL, {
				security: Headway.security,
				action: 'headway_visual_editor',
				method: 'add_template',
				layout: Headway.currentLayout,
				template_name: templateName
			}, function(response) {

				if ( typeof response === 'undefined' || !response ) {
					showErrorNotification({
						id: 'error-could-not-add-template',
						message: 'Error: Could not add template.'
					});

					return false;
				}

				//Need to add the new template BEFORE the add button
				var newTemplateNode = $('<li class="layout-item">\
					<span data-layout-id="template-' + response.id + '" class="layout layout-template">\
						<strong class="template-name">' + response.name + '</strong>\
						\
						<span class="delete-template" title="Delete Template">Delete</span>\
						\
						<span class="status status-currently-editing">Currently Editing</span>\
						\
						<span class="assign-template layout-selector-button">Use Template</span>\
						<span class="edit layout-selector-button">Edit</span>\
					</span>\
				</li>');

				newTemplateNode.appendTo('div#layout-selector-templates ul');

				//Hide the no templates warning if it's visible
				$('li#no-templates:visible', 'div#layout-selector').hide();

				//We're all good!
				showNotification({
					id: 'template-added',
					message: 'Template added!'
				});

				//Clear template name input value
				$('#template-name-input').val('');

			}, 'json');

			return false;

		});

		$('div#layout-selector').delegate('span.delete-template', 'click', function(event){

			var templateLi = $($(this).parents('li')[0]);
			var templateSpan = $(this).parent();
			var template = templateSpan.attr('data-layout-id');
			var templateID = template.replace('template-', '');
			var templateName = templateSpan.find('strong').text();

			if ( !confirm('Are you sure you wish to delete this template?') )
				return false;

			//Do the AJAX request for the new template
			$.post(Headway.ajaxURL, {
				security: Headway.security,
				action: 'headway_visual_editor',
				method: 'delete_template',
				template_to_delete: templateID
			}, function(response) {

				if ( typeof response === 'undefined' || response == 'failure' || response != 'success' ) {
					showErrorNotification({
						id: 'error-could-not-deleted-template',
						message: 'Error: Could not delete template.'
					});

					return false;
				}

				//Delete the template from DOM
				templateLi.remove();

				//Show the no templates message if there are no more templates
				if ( $('span.layout-template', 'div#layout-selector').length === 0 ) {
					$('li#no-templates', 'div#layout-selector').show();
				}

				//We're all good!
				showNotification({
					id: 'template-deleted',
					message: 'Template <em>' + templateName + '</em> successfully deleted!'
				});

				//If the template that was removed was the current one, then send the user back to the blog index or front page
				if ( template === Headway.currentLayout ) {

					var defaultLayout = Headway.frontPage == 'posts' ? 'index' : 'front_page';

					switchToLayout($('div#layout-selector span.layout[data-layout-id="' + defaultLayout + '"]'), true, false);

				}

			});

			return false;

		});

		$('div#layout-selector').delegate('span.assign-template', 'click', function(event){

			var templateNode = $($(this).parents('li')[0]);
			var template = $(this).parent().attr('data-layout-id').replace('template-', '');

			//If the current layout being edited is a template trigger an error.
			if ( Headway.currentLayout.indexOf('template-') === 0 ) {
				alert('You cannot assign a template to another template.');

				return false;
			}

			//Do the AJAX request to assign the template
			$.post(Headway.ajaxURL, {
				security: Headway.security,
				action: 'headway_visual_editor',
				method: 'assign_template',
				template: template,
				layout: Headway.currentLayout
			}, function(response) {

				if ( typeof response === 'undefined' || response == 'failure' ) {
					showErrorNotification({
						id: 'error-could-not-assign-template',
						message: 'Error: Could not assign template.'
					});

					return false;
				}

				$('li.layout-selected', 'div#layout-selector').removeClass('layout-item-customized');
				$('li.layout-selected', 'div#layout-selector').addClass('layout-item-template-used');

				$('li.layout-selected > span.status-template', 'div#layout-selector').text(response);

				//Reload iframe

					showIframeLoadingOverlay();

					//Change title to loading
					changeTitle('Visual Editor: Assigning Template');
					startTitleActivityIndicator();

					Headway.currentLayoutTemplate = 'template-' + template;
					Headway.currentLayoutTemplateName = $('span.layout[data-layout-id="template-' + template + '"]').find('.template-name').text();

					//Reload iframe and new layout
					headwayIframeLoadNotification = 'Template assigned successfully!';

					loadIframe(Headway.instance.iframeCallback);

				//End reload iframe

			});

			return false;

		});

		$('div#layout-selector').delegate('span.remove-template', 'click', function(event){

			var layoutNode = $($(this).parents('li')[0]);
			var layoutID = $(this).parent().attr('data-layout-id');

			if ( !confirm('Are you sure you want to remove the template from ' + layoutNode.find('> span.layout strong').text() + '?') )
				return false;

			//Do the AJAX request to assign the template
			$.post(Headway.ajaxURL, {
				security: Headway.security,
				action: 'headway_visual_editor',
				method: 'remove_template_from_layout',
				layout: layoutID
			}, function(response) {

				if ( typeof response === 'undefined' || response == 'failure' ) {
					showErrorNotification({
						id: 'error-could-not-remove-template-from-layout',
						message: 'Error: Could not remove template from layout.'
					});

					return false;
				}

				layoutNode.removeClass('layout-item-template-used');

				if ( response === 'customized' ) {
					layoutNode.addClass('layout-item-customized');
				}

				//If the current layout is the one with the template that we're unassigning, we need to reload the iframe.
				if ( layoutID == Headway.currentLayout ) {

					showIframeLoadingOverlay();

					//Change title to loading
					changeTitle('Visual Editor: Removing Template From Layout');
					startTitleActivityIndicator();

					Headway.currentLayoutTemplate = false;

					//Reload iframe and new layout
					headwayIframeLoadNotification = 'Template removed from layout successfully!';

					loadIframe(Headway.instance.iframeCallback);

					return true;

				}

				//We're all good!
				return true;

			});

			return false;

		});

		/* Handle Collapsing Stuff */
		$('div#layout-selector').delegate('span', 'click', function(event){

			if ( $(this).hasClass('layout-open') ) {

				$(this).removeClass('layout-open');
				$(this).siblings('ul').hide();

			} else {

				$(this).addClass('layout-open');
				$(this).siblings('ul').show();

			}

		});
	/* END PAGE SWITCHER */


	/* PANEL */
		$('ul#modes li').on('click', function(){
			$(this).siblings('li').removeClass('active');
			$(this).addClass('active');
		});

		$('div#panel').tabs({
			tabTemplate: "<li><a href='#{href}'>#{label}</a></li>",
			add: function(event, ui, content) {

				$(ui.panel).append(content);

			},
			activate: function(event, ui) {

				var tabID = $(ui.newTab).children('a').attr('href').replace('#', '').replace('-tab', '');

				$i('.block-selected').removeClass('block-selected block-hover');

				if ( tabID.indexOf('block-') === 0 )
					$i('#' + tabID).addClass('block-selected block-hover');

			}
		});

		$('ul#panel-top li a').on('click', showPanel);

		$('div.sub-tab').tabs();

		/* PANEL RESIZING */
			var panelMinHeight = 120;
			var panelMaxHeight = function() { return $(window).height() - 275; };

			var resizePanel = function(panelHeight, resizingWindow) {

				if ( typeof panelHeight == 'undefined' || panelHeight == false )
					var panelHeight = $('div#panel').height();

				if ( panelHeight > panelMaxHeight() )
					panelHeight = (panelMaxHeight() > panelMinHeight) ? panelMaxHeight() : panelMinHeight;

				if ( panelHeight < panelMinHeight )
					panelHeight = panelMinHeight;

				if ( typeof resizingWindow != 'undefined' && resizingWindow && panelHeight < panelMaxHeight() )
					return;

				$('div#panel').css('height', panelHeight);

				var iframeBottomPadding = $('div#panel').hasClass('panel-hidden') ? $('ul#panel-top').outerHeight() : $('div#panel').outerHeight();
				var layoutSelectorBottomPadding = $('div#panel').hasClass('panel-hidden') ? $('ul#panel-top').outerHeight()  + $('div#layout-selector-tabs').height() : $('div#panel').outerHeight() + $('div#layout-selector-tabs').height();

				$('div#iframe-container').css({bottom: iframeBottomPadding});

				if ( $('div#panel').hasClass('panel-hidden') )
					$('div#panel').css({'bottom': -$('div#panel').height()});

				$.cookie('panel-height', panelHeight);

			}

			/* Resize the panel according to the cookie right on VE load */
			if ( $.cookie('panel-height') )
				resizePanel($.cookie('panel-height'));

			/* Make the resizing handle actually work */
			$('div#panel').resizable({
				maxHeight: panelMaxHeight(),
				minHeight: 120,
				handles: 'n',
				resize: function(event, ui) {

					$(this).css({
						width: '100%',
						position: 'fixed',
						bottom: 0,
						top: ''
					});

					/* Adjust Padding */
						$('div#iframe-container').css({bottom: $('div#panel').outerHeight()});

					/* Refresh iframe overlay size so it continues to cover iframe */
					showIframeOverlay();

				},
				start: function() {

					showIframeOverlay();

				},
				stop: function() {

					$.cookie('panel-height', $(this).height());

					hideIframeOverlay();

				},
			});

			/* The max height option on the resizable must be updated if the window is resized. */
			$(window).bind('resize', function(event) {

				/* For some reason jQuery UI resizable triggers window resize so only fire if window is truly the target. */
				if ( event.target != window )
					return;

				$('div#panel').resizable('option', {maxHeight: panelMaxHeight()});

				resizePanel(false, true);

			});

			$('div#panel > .ui-resizable-handle.ui-resizable-n')
				.attr('id', 'panel-top-handle')
				.html('<span></span><span></span><span></span>');
		/* END PANEL RESIZING */

		/* PANEL TOGGLE */
			$('div#panel-top-container').bind('dblclick', function(event) {

				if ( event.target.id != 'panel-top-container' )
					return false;

				togglePanel();

			});

			$('ul#panel-top-right li#minimize').bind('click', function(event) {

				togglePanel();

				return false;

			});

			/* Check for cookie */
			if ( $.cookie('hide-panel') === 'true' ) {

				hidePanel(true);

			}
		/* END PANEL TOGGLE */

		/* PANEL SCROLLING */
			addPanelScrolling();
		/* END PANEL SCROLLING */
	/* END PANEL */


	/* TOOLS */
		$('#tools-undo').bind('click', undo);
		$('#tools-redo').bind('click', redo);

		$('#tools-grid-wizard').bind('click', function(){

			hidePanel();

			openBox('grid-wizard');

		});

		$('#tools-tour').bind('click', startTour);

		$('#open-live-css').bind('click', function() {

			openBox('live-css');

			//If Live CSS hasn't been set up then initiate CodeMirror or Tabby
			if ( typeof liveCSSInit == 'undefined' || liveCSSInit == false ) {

				//Set up CodeMirror
				if ( Headway.disableCodeMirror != true ) {
					liveCSSEditor = CodeMirror.fromTextArea($('textarea#live-css')[0], {
						lineWrapping: true,
						tabMode: 'shift',
						mode: 'css',
						lineNumbers: true,
						onCursorActivity: function() {
							liveCSSEditor.setLineClass(hlLine, null);
							hlLine = liveCSSEditor.setLineClass(liveCSSEditor.getCursor().line, "activeline");
						},
						onChange: function(instance) {

							var value = instance.getValue();

							dataHandleInput($('textarea#live-css'), value);
							$i('style#live-css-holder').html(value);

							allowSaving();

						},
						undoDepth: 80
					});

					liveCSSEditor.setValue($('textarea#live-css').val());
					liveCSSEditor.focus();

					var hlLine = liveCSSEditor.setLineClass(0, "activeline");

				//Set up Tabby and the text area if CodeMirror is disabled
				} else {

					$('textarea#live-css').tabby();

					$('textarea#live-css').bind('keyup', function(){

						dataHandleInput($(this));

						$i('style#live-css-holder').html($(this).val());

						allowSaving();

					});

				}

				liveCSSInit = true;

			}

		});

		$('#tools-clear-cache').bind('click', function(){

			/* Set up parameters */
			var parameters = {
				security: Headway.security,
				action: 'headway_visual_editor',
				method: 'clear_cache'
			};

			/* Do the stuff */
			$.post(Headway.ajaxURL, parameters, function(response){

				if ( response === 'success' ) {

					showNotification({
						id: 'cache-cleared',
						message: 'The cache was successfully cleared!'
					});

				} else {

					showErrorNotification({
						id: 'error-could-not-clear-cache',
						message: 'Error: Could not clear cache.'
					});

				}

			});

		});
	/* END TOOLS */


	/* INPUTS */
		/* Run the function */
		delegatePanelInputs();
		bindPanelInputs();
	/* END INPUTS */


	/* START TOUR */
		if ( Headway.ranTour[Headway.mode] == false && Headway.ranTour.legacy == false ) {
			startTour();
		}
	/* END START TOUR */

	/* Fade body in */
	$('body').addClass('show-ve');

});
})(jQuery);