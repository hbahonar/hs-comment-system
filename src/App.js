import './App.css'
import { useCallback, useEffect, useState } from 'react'

function App() {
  const [post, setPost] = useState()
  const [comments, setComments] = useState()
  const [name, setName] = useState('')
  const [email, setEmail] = useState('')
  const [parentId, setParentId] = useState({ id: 0, name: '' })
  const [comment, setComment] = useState('')

  const getPost = useCallback(async () => {
    try {
      await fetch('http://localhost:8081/hs-comment-system/api/post/1')
        .then((respose) => {
          if (respose.ok) {
            return respose.json()
          }
          throw new Error('error')
        })
        .then(async (data) => {
          setPost(data.post)
          await fetch(
            `http://localhost:8081/hs-comment-system/api/comments/${data.post.id}`,
          )
            .then((respose) => {
              if (respose.ok) {
                return respose.json()
              }
              throw new Error('error')
            })
            .then((data) => {
              if (data.comments) {
                setComments(data.comments)
              } else {
                //set error
              }
            })
        })
    } catch (error) {
      console.log(error.message)
    }
  }, [])

  useEffect(() => {
    getPost()
  }, [getPost])

  const submitHandler = async (event) => {
    event.preventDefault()
    try {
      await fetch('http://localhost:8081/hs-comment-system/api/addcomment', {
        method: 'POST',
        body: JSON.stringify({
          postId: 1,
          comment: comment,
          name: name,
          email: email,
          parentId: parentId.id,
        }),
      })
        .then((respose) => {
          if (respose.ok) {
            return respose.json()
          }
          throw new Error('error')
        })
        .then((data) => {
          if (data.comments) {
            setComments(data.comments)
            setParentId({ id: 0, name: '' })
            setName('')
            setEmail('')
            setComment('')
          } else {
            //set error
          }
        })
    } catch (error) {
      console.log(error.message)
    }
  }
  const arrangeComments = (parent_id) => {
    return (
      <>
        {comments.map((comment) => {
          return (
            comment.parent_id === parent_id && (
              <>
                <div
                  className="comment"
                  style={{
                    border: '1px solid #333333',
                    padding: '10px',
                    borderRadius: '5px',
                    marginBottom: '10px',
                  }}
                >
                  <div style={{ display: 'flex', alignItems: 'center' }}>
                    <div style={{ width: '50%' }}>
                      {comment.user_name
                        ? comment.user_name
                        : comment.admin_name}
                    </div>
                    <div
                      style={{
                        width: '50%',
                        display: 'flex',
                        justifyContent: 'end',
                      }}
                    >
                      {comment.date}
                      <span
                        style={{
                          marginLeft: '15px',
                          border: '1px solid #333',
                          display: 'inline-block',
                          padding: '5px',
                          cursor: 'pointer',
                        }}
                        onClick={() => {
                          setParentId({
                            id: comment.id,
                            name: comment.user_name
                              ? comment.user_name
                              : comment.admin_name,
                          })
                        }}
                      >
                        Reply
                      </span>
                    </div>
                  </div>
                  <div>{comment.comment}</div>
                </div>
                <div className="sub-comment" style={{ marginLeft: '30px' }}>
                  {has_children(comment.id) === true &&
                    arrangeComments(comment.id)}
                </div>
              </>
            )
          )
        })}
      </>
    )
  }

  function has_children(id) {
    let result = false
    comments.forEach((comment) => {
      if (comment.parent_id === id) {
        result = true
      }
    })
    return result
  }

  return (
    <div className="App" style={{marginTop:'15px',marginBottom:'15px'}}>
      {post && (
        <div
          style={{
            maxWidth: '1170px',
            marginLeft: 'auto',
            marginRight: 'auto',
          }}
        >
          <article>
            <div>
              {post.thumbnail && (
                <img
                  src={post.thumbnail}
                  alt={post.title}
                  style={{ maxWidth: '600px' }}
                />
              )}
            </div>
            <h1>{post.title}</h1>
            <p>{post.content}</p>
          </article>
          <section>
            <div>{comments && <>{arrangeComments(0)}</>}</div>
            <form
              className="comment-form"
              onSubmit={submitHandler}
              style={{ border: '1px solid #333', padding: '10px',maxWidth:'50%' }}
            >
              {parentId.id > 0 && (
                <div>
                  Reply to: {parentId.name}
                  <span
                    style={{
                      marginLeft: '30px',
                      border: '1px solid #333',
                      padding: '3px',
                      cursor:'pointer',
                      borderRadius:'2px'
                    }}
                    onClick={() => {
                      setParentId({ id: 0, name: '' })
                    }}
                  >
                    X
                  </span>
                </div>
              )}
              <div style={{ display: 'flex', marginTop: '15px' }}>
                <div style={{ width: '50%' }}>
                  <label style={{ width: '100%' }}>Name</label>
                  <input
                    style={{ width: '100%', padding: '5px' }}
                    type="text"
                    value={name}
                    onChange={(event) => {
                      setName(event.target.value)
                    }}
                  />
                </div>
                <div style={{ width: '50%' }}>
                  <label style={{ width: '100%' }}>Email</label>
                  <input
                    style={{ width: '100%', padding: '5px' }}
                    type="text"
                    value={email}
                    onChange={(event) => {
                      setEmail(event.target.value)
                    }}
                  />
                </div>
              </div>
              <div style={{ marginTop: '15px' }}>
                <label style={{ width: '100%' }}>Comment</label>
                <textarea
                  style={{ width: '100%', padding: '5px' }}
                  value={comment}
                  onChange={(event) => {
                    setComment(event.target.value)
                  }}
                />
              </div>
              <div>
                <input
                  type="submit"
                  value="Send"
                  style={{
                    padding: '15px',
                    background: '#333',
                    color: '#fff',
                    border: 'none',
                    marginTop: '15px',
                  }}
                />
              </div>
            </form>
          </section>
        </div>
      )}
    </div>
  )
}

export default App
