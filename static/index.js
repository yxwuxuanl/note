const
    vm = new Vue({
        el : '#app',

        data : {
            notes : [],
            page : 1,
            moods : {
                n : ['#3399ff', 'ios-pricetags-outline'],
                h : ['#00cc66', 'happy-outline'],
                m : ['#00cc66', 'ios-heart-outline'],
                s : ['#ff3300', 'sad-outline'],
            },
            filters : ['n', 's', 'm', 'h'],
            start : new Date('2016/3/2').getTime(),

            collapse : '0',

            order : 'desc',

            count : {
                n : [0, 0, 0],
                h : [0, 0, 0],
                m : [0, 0, 0],
                s : [0, 0, 0]
            },

            // 文档末
            pageEnd : false,

            // 文档头
            pageTop : true,

            // 记录集末
            eof : false,

            newNote : {
                content : '',
                mood : 'n',
                type : '0',
                image : '',
                date : '',
                uploading : false
            }
        },

        created()
        {
            window.onscroll = () => {

                let
                    clientHeight = document.body.clientHeight,
                    scrollTop = document.body.scrollTop,
                    screenHeight = window.screen.height;

                this.pageEnd = clientHeight > screenHeight && (scrollTop + screenHeight) - clientHeight >= 0;
                this.pageTop = scrollTop <= screenHeight;
            };

            return axios.get('./api/getCount.php').then(response => {

                let
                    sum = response.data.sum;

                delete response.data.sum;

                for(let mood in response.data)
                {
                    this.count[mood] = [Number(response.data[mood]) ,0, Math.ceil((Number(response.data[mood]) / sum) * 100)];
                }

            }).then(() => {

                this.fetch();

            });
        },

        methods : {
            fetch()
            {
                let
                    filter = this.filters.join(',');

                return axios.get(`./api/get.php?page=${this.page}&order=${this.order}`).then(response => {

                    response.data.map(note => {
                        this.count[note.mood][1] += 1;
                    });

                    this.notes = this.notes.concat(response.data);
                });
            },

            more()
            {
                this.page += 1;
                this.pageEnd = false;
                this.fetch();
            },

            getImageUrl(prefix)
            {
                return `./static/images/${prefix}.png`;
            },

            isEof()
            {
                let
                    eof = true;

                this.filters.map(mood => {
                    if(this.count[mood][0] > this.count[mood][1])
                    {
                        eof = false;
                        return false;
                    }
                });

                this.eof = eof;
            },

            getDiff(time)
            {
                if(!time)
                {
                    time = new Date().getTime();
                }else{
                    time = new Date(time.replace(/-/g, '/')).getTime();
                }
                
                return parseInt((time - this.start) / (1000 * 3600 * 24));
            },

            getPercent(mood)
            {
                return Math.ceil((Number(this.count[mood]) / this.sum) * 100);
            },

            incr(mood)
            {
                this.count[mood][1] += 1;
            },

            reverse()
            {
                document.body.scrollTop = 0;
                this.notes = this.notes.reverse();
            },

            uploadSuccess(response)
            {
                this.newNote.uploading = false;
                this.newNote.image = response;
            },

            beforeUpload()
            {
                this.newNote.uploading = true;
            },

            post()
            {
                let
                    data, note = this.newNote;

                !note.date && (note.date = this.date);

                data = `content=${note.content}`;
                data += `&image=${note.image}`;
                data += `&mood=${note.mood}`;
                data += `&type=${note.type}`;
                data += `&date=${note.date}`;

                axios.post('./api/add.php', data).then(response => {

                    if(response.data.status === 'success')
                    {
                        if(this.order === 'desc')
                        {
                            this.notes = [note].concat(this.notes);
                        }else{
                            this.notes = this.notes.concat(note);
                        }

                        this.$Message.success('Done!');
                        
                        this.newNote = {
                            content : '',
                            mood : 'n',
                            type : '0',
                            image : '',
                            date : '',
                            uploading : false
                        };
                        this.collapse = '0';
                    }

                });
            }
        },

        computed : {
            sum()
            {
                let
                    count = 0;
                
                for(let mood in this.moods)
                {
                    count += Number(this.count[mood] || 0);
                }

                return count;
            },
            date()
            {
                let
                    date = new Date();

                return `${date.getFullYear()}-${date.getMonth()}-${date.getDay()}`;
            }
        },

        watch : {
            pageEnd(v)
            {
                if(v)
                {
                    this.collapse = '0';
                }
            },

            filters()
            {
                this.isEof();
                this.collapse = '0';
            },

            notes()
            {
                this.isEof();
            },

            pageTop()
            {
                this.collapse = '0';
            }
        }

    });