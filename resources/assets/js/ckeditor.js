import CKEditorUploadAdapter from '../../../../../core/base/resources/assets/js/ckeditor-upload-adapter';

export default function initCkEditor(element, extraConfig) {
    const editor = document.querySelector('#' + element);

    if (window.EDITOR) {
        if (EDITOR.CKEDITOR[element]) {
            return;
        }
    }

    ClassicEditor
        .create(editor, {
            fontSize: {
                options: [
                    9,
                    11,
                    13,
                    'default',
                    17,
                    16,
                    18,
                    19,
                    21,
                    22,
                    23,
                    24
                ]
            },
            alignment: {
                options: ['left', 'right', 'center', 'justify']
            },

            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                    { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' }
                ]
            },
            placeholder: ' ',
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'fontColor',
                    'fontSize',
                    'fontBackgroundColor',
                    'fontFamily',
                    'bold',
                    'italic',
                    'underline',
                    'link',
                    'strikethrough',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'alignment',
                    'direction',
                    'outdent',
                    'indent',
                    '|',
                    'htmlEmbed',
                    'imageInsert',
                    'blockQuote',
                    'insertTable',
                    'mediaEmbed',
                    'undo',
                    'redo',
                    'findAndReplace',
                    'removeFormat',
                    'sourceEditing',
                    'codeBlock',
                ]
            },
            language: {
                ui: 'en',

                content: window.siteEditorLocale || 'en',
            },
            image: {
                toolbar: [
                    'imageTextAlternative',
                    'imageStyle:inline',
                    'imageStyle:block',
                    'imageStyle:side',
                    'toggleImageCaption',
                    'ImageResize',
                ],
                upload: {
                    types: ['jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'svg+xml']
                }
            },
            codeBlock: {
                languages: [
                    { language: 'plaintext', label: 'Plain text' },
                    { language: 'c', label: 'C' },
                    { language: 'cs', label: 'C#' },
                    { language: 'cpp', label: 'C++' },
                    { language: 'css', label: 'CSS' },
                    { language: 'diff', label: 'Diff' },
                    { language: 'html', label: 'HTML' },
                    { language: 'java', label: 'Java' },
                    { language: 'javascript', label: 'JavaScript' },
                    { language: 'php', label: 'PHP' },
                    { language: 'python', label: 'Python' },
                    { language: 'ruby', label: 'Ruby' },
                    { language: 'typescript', label: 'TypeScript' },
                    { language: 'xml', label: 'XML' },
                    { language: 'dart', label: 'Dart', class: 'language-dart' },
                ]
            },
            link: {
                defaultProtocol: 'http://',
                decorators: {
                    openInNewTab: {
                        mode: 'manual',
                        label: 'Open in a new tab',
                        attributes: {
                            target: '_blank',
                            rel: 'noopener noreferrer'
                        }
                    }
                }
            },
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells',
                    'tableCellProperties',
                    'tableProperties'
                ]
            },
            htmlSupport: {
                allow: [
                    {
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true
                    }
                ]
            },
            ...extraConfig,
        })
        .then(editor => {
            window.EDITOR.CKEDITOR[element] = editor;
            editor.plugins.get('FileRepository').createUploadAdapter = loader => {
                return new CKEditorUploadAdapter(loader, RV_MEDIA_URL.media_upload_from_editor, editor.t);
            };

            // create function insert html
            editor.insertHtml = html => {
                const viewFragment = editor.data.processor.toView(html);
                const modelFragment = editor.data.toModel(viewFragment);
                editor.model.insertContent(modelFragment);
            }

            const minHeight = $('#' + element).prop('rows') * 90;
            const className = `ckeditor-${element}-inline`;
            $(editor.ui.view.editable.element)
                .addClass(className)
                .after(`
                <style>
                    .ck-editor__editable_inline {
                        min-height: ${minHeight - 100}px;
                        max-height: ${minHeight + 100}px;
                    }
                </style>
            `);

            // debounce content for ajax ne
            let timeout;
            editor.model.document.on('change:data', () => {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    editor.updateSourceElement();
                }, 150)
            });

            // insert media embed
            editor.commands._commands.get('mediaEmbed').execute = url => {
                editor.insertHtml(`[media url="${url}"][/media]`);
            }
        })
        .catch(error => {
            console.error(error);
        });
}
